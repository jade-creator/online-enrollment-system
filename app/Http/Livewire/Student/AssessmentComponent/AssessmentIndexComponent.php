<?php

namespace App\Http\Livewire\Student\AssessmentComponent;

use App\Models;
use App\Services\Assessment\AssessmentComputationService;
use App\Services\Assessment\AssessmentService;
use App\Services\ProgramService;
use App\Services\Registration\RegistrationService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class AssessmentIndexComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Registration $registration;
    public Models\Assessment $assessment;
    public ?float $grandTotal = null;
    public float $totalUnit = 0;
    public string $additional = '0';
    public array $fees = [];
    public bool $isUnifastBeneficiary = false;

    public function rules()
    {
        return [
            'isUnifastBeneficiary' => ['required'],
            'additional' => ['required', 'numeric', 'min:0'],
            'assessment.isPercentage' => ['nullable'],
            'assessment.discount_amount' => ['required', 'numeric', 'min:0'],
            'assessment.remarks' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function mount()
    {
        try {
            $this->fees = (new ProgramService())->combineFees($this->registration, $this->totalUnit);

            if (isset($this->registration->assessment)) {
                $this->assessment = $this->registration->assessment;
            } else {
                $this->fill([
                    'assessment' => new Models\Assessment(),
                    'assessment.isPercentage' => null,
                    'assessment.discount_amount' => 0,
                ]);
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function render() { return
        view('livewire.student.assessment-component.assessment-index-component');
    }

    public function save()
    {
        try {
            $this->fill([
                'assessment.isUnifastBeneficiary' => $this->isUnifastBeneficiary,
                'assessment.additional' => $this->additional,
                'assessment.grand_total' => $this->grandTotal,
                'assessment.balance' => $this->grandTotal,
            ]);

            $this->assessment = (new AssessmentService())->store($this->registration, $this->assessment);
            $this->cancel();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function compute()
    {
        $this->validate();

        try {
            $this->authorize('create', Models\Assessment::class);

            $this->fill([
                'grandTotal' => $this->isUnifastBeneficiary == true ? 0
                    : (new AssessmentComputationService())->computeGrandTotal($this->additional, $this->totalUnit,
                    $this->fees, $this->assessment),
                'registration' => (new RegistrationService())->saveFees($this->registration, $this->fees),
            ]);

            $this->registration->refresh();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function cancel() { return
        $this->redirect(route('pre.registration.view', ['regId' => $this->registration->id]));
    }

    public function updatedAssessmentIsPercentage($value) {
        if (empty($value)) $this->assessment->discount_amount = 0;
    }
}
