<?php

namespace App\Observers;

use App\Models\Assessment;

class AssessmentObserver
{
    public function creating(Assessment $assessment)
    {
        $assessment->approver_id = auth()->user()->id;
    }
}
