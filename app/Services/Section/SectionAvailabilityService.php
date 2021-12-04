<?php

namespace App\Services\Section;

use App\Models\Section;
use App\Models\Setting;

class SectionAvailabilityService
{
    /**
     * @throws \Exception
     */
    public function isFull(int $sectionId) : bool
    {
        $section = Section::with(['registrations' => function($query) {
                return $query->whereNull('released_at')
                        ->where('status_id', 4);
            }])
            ->find($sectionId);

        $setting = Setting::get()->first();

        if ($setting->max_slots <= $section->registrations->count()) {

            if ($section->isFull == 0) $section->update(['isFull' => 1]);

            throw new \Exception($section->name.' is already full.');
        } else {
            if ($section->isFull == 1) $section->update(['isFull' => 0]);
        }

        return false;
    }
}
