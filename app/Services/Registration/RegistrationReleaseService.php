<?php

namespace App\Services\Registration;

use App\Models\Section;

class RegistrationReleaseService
{
    public int $statusId;

    public function __construct(int $statusId = null)
    {
        $this->statusId = $statusId;
    }

    public function release($registrations)
    {
        if ($registrations->count() > 0) {
            foreach ($registrations as $registration ) {
                $registration->status_id = $this->statusId;
                $registration->released_at = now();
                $registration->save();
            }
        }
    }

    public function releaseAll(array $selected)
    {
        $sections = Section::with(['registrations' => function($query) {
            return $query->whereNull('released_at');
        }])
            ->whereIn('id', $selected)
            ->get();

        $sections->map( fn($section) => $this->release($section->registrations) );
    }
}
