<?php

namespace App\Services\Registration;

use App\Models;
use App\Services\Schedule\ScheduleMergeabilityService;
use App\Services\Section\SectionAvailabilityService;

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
                if (is_null($extension->registration->section_id)) throw new \Exception('Please select a section.');

                $blocks = $registrationService->populateSchedules($extension->registration->section, $days);

                if ($registrationService->checkBlock($schedules, $blocks)) throw new \Exception('Unable to submit. Conflict on schedule was detected.');

                $registration_t = $this->submit($extension->registration);
            }
        }

        $registration->status_id = $status->id;
        $registration->update();

        return $registration;
    }

    /**admin reject student's registration.
     * @throws \Exception
     */
    public function reject(Models\Registration $registration) : Models\Registration
    {
        $status = $this->findStatus('denied');

        $registration->section_id = null;
        return $this->setStatus($registration, $status);
    }

    /**
     * @throws \Exception
     */
    public function pending(Models\Registration $registration) : Models\Registration
    {
        $status = $this->findStatus('pending');

        $registration->section_id = null;
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
        $registration = $this->setStatus($registration, $status);

        if (! $registration->student->isStudent) {
            $registration->student->isStudent = true;
            $registration->student->save();
        }

        return $registration;
    }
}
