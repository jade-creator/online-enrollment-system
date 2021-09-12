<?php

namespace App\Services\Registration;


use App\Models;

class RegistrationService
{
    public function pluckSubjectsId($data) : array {
        return $data->pluck('id')->toArray();
    }

    /**
     * @throws \Exception
     */
    public function store(array $selected, Models\Registration $registration) : Models\Registration
    {
        if (empty($selected)) throw new \Exception('No Selected Subject/s.');

        $status = Models\Status::where('name', 'pending')->firstOrFail();
        $mark = Models\Mark::where('name', 'tba')->firstOrFail();

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
