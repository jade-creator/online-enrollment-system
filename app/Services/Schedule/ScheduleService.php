<?php

namespace App\Services\Schedule;

use App\Models;

class ScheduleService
{
    /**
     * @throws \Exception
     */
    public function checkMergeability(bool $bool) {
        if ($bool) throw new \Exception('Time Collision: cannot update schedule due to time period is already occupied.');
    }

    /**
     * @throws \Exception
     */
    public function store(Models\Section $section, Models\Schedule $schedule, $days = null) : Models\Schedule
    {
        if (empty($days)) throw new \Exception('Error Occurred: parameter is missing.');

        $this->checkMergeability( (new ScheduleMergeabilityService())->checkSchedule($section, $schedule, $days) );

        $schedule->section_id = $section->id;
        $schedule->save();

        return $schedule;
    }

    /**
     * @throws \Exception
     */
    public function update(Models\Schedule $schedule, array $schedules = []) : Models\Schedule
    {
        $this->checkMergeability( (new ScheduleMergeabilityService())->allowUpdateOnSchedule($schedule, $schedules) );

        $schedule->update();

        return $schedule;
    }
}
