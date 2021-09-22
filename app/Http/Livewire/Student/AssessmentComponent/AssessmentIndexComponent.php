<?php

namespace App\Http\Livewire\Student\AssessmentComponent;

use App\Models;
use App\Services\Assessment\AssessmentComputationService;
use App\Services\Assessment\AssessmentService;
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

    public function rules()
    {
        return [
            'additional' => ['required', 'numeric', 'min:0'],
            'assessment.isPercentage' => ['nullable'],
            'assessment.discount_amount' => ['required', 'numeric', 'min:0'],
            'assessment.remarks' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function mount() {
        try {
            if ($this->registration->prospectus->program->fees->isNotEmpty()) {
                $category = Models\Category::where('name', 'Tuition Fee (multiplied by unit/s)')->first();

                foreach ($this->registration->prospectus->program->fees as $fee) {
                    $totalFee = $fee->price;
                    if ($category && $fee->category_id == $category->id) $totalFee = $this->totalUnit * $fee->price;

                    $this->fees[$fee->id] = [TRUE, $totalFee];
                }
            }

            $this->fill([
                'assessment' => new Models\Assessment(),
                'assessment.isPercentage' => null,
                'assessment.discount_amount' => 0,
            ]);

            if (isset($this->registration->assessment)) $this->assessment = $this->registration->assessment;
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
            $this->authorize('create', $this->assessment);

            $this->grandTotal = (new AssessmentComputationService())->computeGrandTotal($this->additional, $this->totalUnit, $this->fees, $this->assessment);

            $this->registration = (new RegistrationService())->saveFees($this->registration, $this->fees);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function cancel() { return
        $this->redirect(route('pre.registration.view', ['regId' => $this->registration->id]));
    }
}
