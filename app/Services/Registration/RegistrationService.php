<?php

namespace App\Services\Registration;


use App\Models;
use FontLib\TrueType\Collection;

class RegistrationService
{
    public function releaseAllRegistrations($registrations)
    {
        $registrations = $registrations->filter(function ($registration) {
            return $registration->released_at == null;
        });

        $registrationIds = $registrations->pluck('id')->toArray();

        Models\Registration::whereIn('id', $registrationIds)->update(['released_at' => now()]);
    }

    public function createNewRegistration(string $prospectusId = '', string $studentId = '', string $curriculumId = '',
      int $totalUnit = 0, bool $isExtension = false, bool $isRegular = false) : Models\Registration
    {
        $registration = new Models\Registration();

        $registration->prospectus_id = $prospectusId;
        $registration->student_id = $studentId;
        $registration->isRegular = $isRegular;
        $registration->isExtension = $isExtension;
        $registration->total_unit = $totalUnit;
        $registration->curriculum_id = $curriculumId;

        return $registration;
    }

    public function combineTotalUnits(Models\Registration $registration)
    {
        $totalUnit = $registration->total_unit;

        if (! $registration->isExtension && $registration->extensions->isNotEmpty()) {
            foreach ($registration->extensions as $extension) {
                $totalUnit += $extension->registration->total_unit;
            }
        }

        return $totalUnit ?? 0;
    }

    public function saveFees(Models\Registration $registration, array $fees = []) : Models\Registration
    {
        if (count($fees) == 0) return $registration;

        $registration->fees()->detach();

        foreach ($fees as $key => $fee) {
            if ($fee[0]) $registration->fees()->attach($key, ['total_fee' => $fee[1] * 100]);
        }

        return $registration;
    }

    public function arrayMatches(array $subjectEnrolledIds = [], array $scheduleSubjectIds = []) :bool
    {
        if (is_array($subjectEnrolledIds)
            && is_array($scheduleSubjectIds)
            && array_intersect($subjectEnrolledIds, $scheduleSubjectIds) == $subjectEnrolledIds) return TRUE;

        return FALSE;
    }

    public function isSubjectsAvailable(Models\Registration $registration, $schedules) : bool
    {
        return $this->arrayMatches($registration->grades->pluck('prospectus_subject.subject_id')->toArray(),
            array_unique($schedules->pluck('prospectusSubject.subject_id')->toArray()));
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
        $grades = $registration->grades->pluck('prospectus_subject.subject_id')->toArray();
        $schedules = $schedules->filter(fn ($schedule) => in_array($schedule->prospectusSubject->subject_id, $grades));

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

        //update registration status to pending.
        $status = Models\Status::where('name', 'pending')->firstOrFail();
        $mark = Models\Mark::where('name', 'TBA')->firstOrFail();

        $registration->status_id = $status->id;
        $registration->save();

        //attach enrolled subjects as grades on registration.
        $grades = array();

        foreach ($selected as $id) {
            if (isset($id) && $id != FALSE) array_push($grades, new Models\Grade([
                'subject_id' => $id,
                'mark_id' => $mark->id,
            ]));
        }

        $registration->grades()->saveMany($grades);

        //release previous registrations
        if (! $registration->isExtension) $this->releaseAllRegistrations(Models\Registration::where('student_id', $registration->student_id)
            ->where('id', '!=', $registration->id)
            ->whereNull('released_at')
            ->get());

        return $registration;
    }

    /**
     * @throws \Exception
     */
    public function searchDuplicate($prospectusId, $studentId)
    {
        $registrationDuplicate = Models\Registration::where([
            ['prospectus_id', $prospectusId],
            ['student_id', $studentId],
            ['isExtension', 0],
            ['isRegular', 1],
        ])->first();

        //check duplicate of enrollment.
        if (filled($registrationDuplicate)) throw new \Exception('A registration was found for this current semester. Please refer to Registration ID: '.
            $registrationDuplicate->custom_id.'. Duplication is not allowed!');
    }

    /**
     * @throws \Exception
     */
    public function update(array $selected, Models\Registration $registration) : Models\Registration
    {
        $registration = $this->detachGrades($registration);

        return $this->store($selected, $registration);
    }

    public function detachGrades(Models\Registration $registration) : Models\Registration
    {
        if ($registration->grades->isNotEmpty()) $registration->grades()->delete();

        if ($registration->extensions->isNotEmpty()) {
            foreach ($registration->extensions as $extension) {
                $this->detachGrades($extension->registration);
                $extension->delete();
                $extension->registration->delete();
            }
        }

        return $registration;
    }
}
