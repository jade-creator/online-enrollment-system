<?php

namespace App\Services\Registration;


use App\Models;

class RegistrationService
{
    /**
     * @throws \Exception
     */
    public function store(array $selected, Models\Registration $registration, Models\Prospectus $prospectus, int $studentId) : Models\Registration
    {
        if (empty($selected)) throw new \Exception('No Selected Subject/s.');

        $registration->student_id = $studentId;
        $registration->prospectus_id = $prospectus->id;

        $status = Models\Status::where('name', 'pending')->first();
        $mark = Models\Mark::where('name', 'tba')->first();
        if (is_null($status) || is_null($mark)) throw new \Exception("Registration Unsuccessful.");

        $registration->status_id = $status->id;
        $registration->save();

        $grades = [];

        foreach ($selected as $id) {
            $grades[] = new Models\Grade([
                'subject_id' => $id,
                'mark_id' => $mark->id,
            ]);
        }

        $registration->grades()->saveMany($grades);

        return $registration;
    }
}
