<?php

namespace App\Services;

use App\Models\Section;

class Sections
{
    public function isFull($section_id)
    {
        $section = Section::with(['registrations' => function($query) {
                return $query->whereNull('released_at');
            }])
            ->find($section_id);

        if ($section->seat == $section->registrations->count()) return true;

        return false;
    }
}