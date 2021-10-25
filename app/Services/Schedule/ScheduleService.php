<?php

namespace App\Services\Schedule;

use App\Models;

class ScheduleService
{
    /**
     * @throws \Exception
     */
    public function checkMergeability(bool $bool, string $message) {
        if ($bool) throw new \Exception($message);
    }

    /** schedule add component: save
     * @throws \Exception
     */
    public function store(Models\Section $section, Models\Schedule $schedule, $days = null) : Models\Schedule
    {
        if (empty($days)) throw new \Exception('Error Occurred: parameter is missing.');

        $this->checkMergeability( (new ScheduleMergeabilityService())->checkSchedule($section, $schedule, $days),
            'Time Collision: cannot update schedule due to time period is already occupied.');

        $employee = Models\Employee::with('user.person')->findOrFail($schedule->employee_id);

        $this->checkMergeability( (new ScheduleMergeabilityService())->checkProfessorSchedule($schedule, $days),
            $employee->salutation.' '.$employee->user->person->full_name.' is not available for the assigned schedule.');

        $schedule->section_id = $section->id;
        $schedule->save();

        return $schedule;
    }

    /**
     * @throws \Exception
     */
    public function update(Models\Schedule $schedule, array $schedules = []) : Models\Schedule
    {
        $this->checkMergeability( (new ScheduleMergeabilityService())->allowUpdateOnSchedule($schedule, $schedules),
            'Time Collision: cannot update schedule due to time period is already occupied.');

        $schedule->update();

        return $schedule;
    }

    /**
     * @throws \Exception
     */
    public function updateProfSchedule(Models\Schedule $schedule, array $schedules = []) : Models\Schedule
    {
        $employee = Models\Employee::with('user.person')->findOrFail($schedule->employee_id);

        $schedule->save();

        $this->checkMergeability( (new ScheduleMergeabilityService())->allowUpdateOnSchedule($schedule, $schedules),
            $employee->salutation.' '.$employee->user->person->full_name.' is not available for the assigned schedule.');

        return $schedule;
    }

    public function destroy(Models\Schedule $schedule) : Models\Schedule
    {
        $schedule->delete();

        return $schedule;
    }

    public function populateProfessors(Models\Registration $registration) : array
    {
        if ($registration->classes->isEmpty()) return [];

        $professors = [];

        foreach ($registration->classes as $schedule) {
            if (array_key_exists($schedule->prospectus_subject_id, $professors)) continue;

            $professors[$schedule->prospectus_subject_id] = [$schedule->employee->user->person->full_name, $schedule->prospectusSubject->unit];
        }

        return $professors;
    }
}
