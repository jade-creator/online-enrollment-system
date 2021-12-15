<?php

namespace App\Services\Registration;

use App\Models;
use App\Services\Schedule\ScheduleMergeabilityService;
use App\Services\Section\SectionAvailabilityService;
use App\Services\SendNotification;

class RegistrationStatusService
{
    /*change registration status*/
    public function setStatus(Models\Registration $registration, Models\Status $status) : Models\Registration
    {
        $registration->status_id = $status->id;
        $registration->save();

        return $registration;
    }

    /**Query status
     * @throws \Exception
     */
    public function findStatus(string $name) : Models\Status
    {
        $status = Models\Status::where('name', $name)->first();

        if (is_null($status)) throw new \Exception('No Status "'.$name.'" found.');

        return $status;
    }

    //assessment
    public function confirm(Models\Registration $registration) : Models\Registration
    {
        $status = $this->findStatus('finalized');

        if($registration->extensions->isNotEmpty()) {
            foreach ($registration->extensions as $extension) {
                $this->confirm($extension->registration);
            }
        }

        return $this->setStatus($registration, $status);
    }

    /**student submit registration for assessment.
     * @throws \Exception
     */
    public function submit(Models\Registration $registration) : Models\Registration
    {
        $status = $this->findStatus('confirming');

        if (is_null($registration->section_id)) throw new \Exception('Please select a section.');

        if ($registration->extensions->isNotEmpty()) {
            $registrationService = new ScheduleMergeabilityService();
            $days = Models\Day::get('name');
            $schedules = $registrationService->populateSchedules($registration->section, $days);

            foreach ($registration->extensions as $extension) {
                if (is_null($extension->registration->section_id) && $extension->registration->total_unit == 0) continue;

                $blocks = $registrationService->populateSchedules($extension->registration->section, $days);

                if ($registrationService->checkBlock($schedules, $blocks)) throw new \Exception('Unable to submit, conflict on schedule was detected.');

                $this->submit($extension->registration);
            }
        }

        return $this->setStatus($registration, $status);
    }

    /**admin reject student's registration.
     * @throws \Exception
     */
    public function reject(Models\Registration $registration) : Models\Registration
    {
        $status = $this->findStatus('denied');

        if ($registration->extensions->isNotEmpty()) {
            foreach ($registration->extensions as $extension) {
                $this->reject($extension->registration);
            }
        }

        if ($registration->assessment) $registration->assessment()->delete();

        if ($registration->transactions->isNotEmpty()) $registration->transactions()->delete();

        $registration = $this->setStatus($registration, $status);

        //dispatch event
        (new SendNotification())->dispatch(
            auth()->user()->id,
            $registration->student->user_id,
            'Hi '.$registration->student->user->person->firstname."! Registration ID ".$registration->custom_id."'s status: ".$registration->status->name
        );

        return $registration;
    }

    /**
     * @throws \Exception
     */
    public function pending(Models\Registration $registration) : Models\Registration
    {
        $status = $this->findStatus('pending');

        $registration->section_id = null;

        if($registration->extensions->isNotEmpty()) {
            foreach ($registration->extensions as $extension) {
                $this->pending($extension->registration);
            }
        }

        return $this->setStatus($registration, $status);
    }

    /**
     * @throws \Exception
     */
    public function enroll(Models\Registration $registration) : Models\Registration
    {
        (new SectionAvailabilityService())->isFull($registration->section_id);

        $status = $this->findStatus('enrolled');

        $registration->released_at = null;

        if($registration->extensions->isNotEmpty()) {
            foreach ($registration->extensions as $extension) {
                $this->enroll($extension->registration);
            }
        }

        $registration->student->isRegular = $registration->isRegular;
        $registration->student->isNew = $registration->isNew;
        $registration->update();

        $registration = $this->setStatus($registration, $status);
        $registration->refresh();

        //dispatch event
        (new SendNotification())->dispatch(
            auth()->user()->id,
            $registration->student->user_id,
            'Hi '.$registration->student->user->person->firstname."! Registration ID ".$registration->custom_id."'s status: ".$registration->status->name,
            '<a class="underline text-blue-500" target="_blank" href="'.route('stream.registration.pdf', ['id' => $registration->id]).'">Please click here to print your certification.</a>',
        );

        return $registration;
    }
}
