<?php

namespace App\Services\Schedule;

use App\Models;
use Carbon\Carbon;

class CalendarService
{
    public function stripAvailableSlot(array $calendarData = []) : array
    {
        if (empty($calendarData)) return $calendarData;

        foreach($calendarData as $time => $days) {
            $availableCount = 0;

            foreach($days as $index => $value) {

                if (is_array($value) || $value == 0) {
                    continue;
                } else {
                    $availableCount++;
                }

                if (sizeof($days) == $availableCount) unset($calendarData[$time]);
            }
        }

        return $calendarData;
    }

    public function generateCalendarData(Models\Section $section, $weekDays)
    {
        $calendarData = [];
        $timeRange = (new TimeService)->generateTimeRange(config('app.calendar.start_time'), config('app.calendar.end_time'));

        foreach ($timeRange as $time)
        {
            $timeText = $time['start'] . '-' . $time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $day)
            {
                $lesson = $section->schedules->filter( function ($schedule) use ($day, $time) {
                   return $schedule->day_id == $day->id && Carbon::parse($schedule->start_time)->format('H:i') == $time['start'];
                })->first();

                if ($lesson)
                {
                    array_push($calendarData[$timeText], [
                        'class_name'   => $lesson->prospectusSubject->subject->code,
                        'teacher_name' => $lesson->employee->user->person->short_full_name,
                        'rowspan'      => $lesson->difference/30 ?? ''
                    ]);
                }
                else if (! $section->schedules->filter( function ($schedule) use ($day, $time) {
                    return $schedule->day_id == $day->id && Carbon::parse($schedule->start_time)->format('H:i') < $time['start']
                        && Carbon::parse($schedule->end_time)->format('H:i') >=  $time['end'];
                })->count())
                {
                    array_push($calendarData[$timeText], 1);
                }
                else
                {
                    array_push($calendarData[$timeText], 0);
                }
            }
        }

        $strippedHead = $this->stripAvailableSlot($calendarData);

        if (empty($strippedHead)) return $calendarData;

        $strippedTail = $this->stripAvailableSlot(array_reverse($strippedHead));

        return array_reverse($strippedTail);
    }
}
