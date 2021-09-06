<?php

namespace App\Services\Registration;

use App\Models;
use App\Services\Section\SectionAvailabilityService;

class RegistrationStatusService
{
    public function setStatus(Models\Registration $registration, Models\Status $status) : Models\Registration
    {
        $registration->status_id = $status->id;
        $registration->save();

        return $registration;
    }

    /**
     * @throws \Exception
     */
    public function findStatus(string $name) : Models\Status
    {
        $status = Models\Status::where('name', $name)->first();

        if (is_null($status)) throw new \Exception('No Status "'.$name.'" found.');

        return $status;
    }

    /**
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
