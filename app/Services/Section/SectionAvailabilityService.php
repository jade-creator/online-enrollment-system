<?php

namespace App\Services\Section;

use App\Models\Section;

class SectionAvailabilityService
{
    /**
     * @throws \Exception
     */
    public function isFull(int $sectionId) : bool
    {
        $section = Section::with(['registrations' => function($query) {
                return $query->whereNull('released_at');
            }])
            ->find($sectionId);

        if ($section->seat == $section->registrations->count()) throw new \Exception($section->name.' has no seat/s available.');

        return false;
    }
}