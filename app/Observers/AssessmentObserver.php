<?php

namespace App\Observers;

use App\Models\Assessment;
use App\Services\Registration\RegistrationStatusService;

class AssessmentObserver
{
    public function creating(Assessment $assessment)
    {
        $assessment->approver_id = auth()->user()->id;
    }

    /**
     * @throws \Exception
     */
    public function created(Assessment $assessment)
    {
        if ($assessment->isUnifastBeneficiary) (new RegistrationStatusService())->enroll($assessment->registration);
    }
}
