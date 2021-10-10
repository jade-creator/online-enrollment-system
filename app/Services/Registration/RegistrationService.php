<?php

namespace App\Services\Registration;


use App\Models;
use FontLib\TrueType\Collection;

class RegistrationService
{
    public function saveFees(Models\Registration $registration, array $fees = []) : Models\Registration
    {
        if (count($fees) == 0) return $registration;

        $registration->fees()->detach();

        foreach ($fees as $key => $fee) {
            if ($fee[0]) $registration->fees()->attach($key, ['total_fee' => $fee[1] * 100]);
        }

        return $registration;
    }

    public function isSubjectsAvailable(Models\Registration $registration, $schedules) : bool
    {
        $subjectsEnrolled = $registration->grades->pluck('subject_id')->toArray();
        $schedules = array_unique($schedules->pluck('prospectus_subject_id')->toArray());

        if (is_array($subjectsEnrolled)
            && is_array($schedules)
            && count($subjectsEnrolled) == count($schedules)
            && array_diff($subjectsEnrolled, $schedules) === array_diff($schedules, $subjectsEnrolled)) return TRUE;

        return FALSE;
    }

    /**
     * @throws \Exception
     */
    public function selectSection(Models\Registration $registration, int $sectionId, $schedules) : Models\Registration
    {
        if (! $this->isSubjectsAvailable($registration, $schedules)) throw new \Exception('Oopps! Some subject/s are not available yet under this section.');

        $registration->section_id = $sectionId;
        $registration->update();

        //get schedules that student enrolled to.
        $grades = $registration->grades->pluck('subject_id')->toArray();
        $schedules = $schedules->filter(fn ($schedule) => in_array($schedule->prospectus_subject_id, $grades));

        $registration->classes()->sync($schedules->pluck('id')->toArray());

        return $registration;
    }

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
        $mark = Models\Mark::where('name', 'TBA')->firstOrFail();

        $registration->status_id = $status->id;
        $registration->save();

        //attach enrolled subjects as grades on registration.
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
