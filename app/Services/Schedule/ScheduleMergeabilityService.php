<?php

namespace App\Services\Schedule;

use App\Models;
use Carbon\Carbon;

class ScheduleMergeabilityService
{
    public function explodeTimeStringToNumbers(string $blockTime) { return
        explode( '-', preg_replace( '/:/', '.', $blockTime ) );
    }

    //compare schedule and blocks if collides/overlaps.
    public function checkBlock(array $schedule, array $blocks) : bool
    {
        foreach ($blocks as $day => $blockTimes) {
            foreach ($blockTimes as $blockTime) {
                list($blockTimeStart, $blockTimeEnd) = $this->explodeTimeStringToNumbers($blockTime);

                foreach ($schedule[$day] as $scheduleTime) {
                    list($scheduleTimeStart, $scheduleTimeEnd) = $this->explodeTimeStringToNumbers($scheduleTime);

                    if (
                        //block time starts between start and end of schedule time period.
                        ($blockTimeStart >= $scheduleTimeStart && $blockTimeStart <= $scheduleTimeEnd) ||
                        //block time ends between start and end of schedule time period.
                        ($blockTimeEnd >= $scheduleTimeStart && $blockTimeEnd <= $scheduleTimeEnd) ||
                        //block time period overlapped schedule time period.
                        ($blockTimeStart <= $scheduleTimeStart && $blockTimeEnd >= $scheduleTimeEnd)
                    ) {
                        return TRUE;
                    }
                }
            }
        }

        return FALSE;
    }

    public function stringToCarbonTime($time) : string {
        return Carbon::parse($time)->format('H:i');
    }

    /*get current block for update*/
    public function populateBlocks(Models\Schedule $schedule) : array
    {
        $blocks = [];
        $day = Models\Day::findOrFail($schedule->day_id);

        $blocks[$day->name][0] = $this->stringToCarbonTime($schedule->start_time).'-'.$this->stringToCarbonTime($schedule->end_time);

        return $blocks;
    }

    //get schedule of selected section
    public function populateSchedules($section, $days = null) : array
    {
        $schedules = [];

        foreach ($days as $day) {
            $schedules[$day->name] = [];
        }

        foreach ($section->schedules as $scheduleMain) {
            if (array_key_exists($scheduleMain->day->name, $schedules)) {
                $schedules[$scheduleMain->day->name][] = $this->stringToCarbonTime($scheduleMain->start_time).'-'.$this->stringToCarbonTime($scheduleMain->end_time);
            }
        }

        return $schedules;
    }

    /*schedule service: store*/
    public function checkSchedule(Models\Section $section, Models\Schedule $schedule, $days = null) : bool
    {
        if ($section->schedules->isEmpty()) return FALSE;

        $blocks = $this->populateBlocks($schedule);
        $schedules = $this->populateSchedules($section, $days);

        return $this->checkBlock($schedules, $blocks);
    }

    /*schedule service: store*/
    public function checkProfessorSchedule(Models\Schedule $schedule, $days = null) : bool
    {
        $employee = Models\Employee::with('schedules')->findOrFail($schedule->employee_id);

        if ($employee->schedules->isEmpty()) return FALSE;

        $blocks = $this->populateBlocks($schedule);
        $schedules = $this->populateSchedules($employee, $days);

        return $this->checkBlock($schedules, $blocks);
    }

    public function allowUpdateOnSchedule(Models\Schedule $schedule, array $schedules = []) : bool
    {
        $blocks = $this->populateBlocks($schedule);

        return $this->checkBlock($schedules, $blocks);
    }

    //unset selected block time period to schedule.
    public function unsetSchedule($section, array $blocks = [], $days = null) : array
    {
        $schedules = $this->populateSchedules($section, $days);

        foreach ($blocks as $day => $blockTimes) {
            foreach ($blockTimes as $blockTime) {
                foreach ($schedules[$day] as $index => $scheduleTime) {
                    if ($blockTime == $scheduleTime) {
                        unset($schedules[$day][$index]);
                    }
                }
            }
        }

        return $schedules;
    }
}
