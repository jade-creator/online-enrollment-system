<?php

namespace App\Services\Assessment;

use App\Models;

class AssessmentService
{
    public function store(Models\Registration $registration, Models\Assessment $assessment) : Models\Assessment
    {
        $registration->assessment()->save($assessment);

        return $assessment;
    }
}
