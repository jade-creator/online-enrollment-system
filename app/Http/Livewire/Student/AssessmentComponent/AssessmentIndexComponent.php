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
    public Models\Setting $setting;
    public ?float $grandTotal = null;
    public float $totalUnit = 0, $downpayment = 0, $amountDue = 0;
    public string $additional = '0', $first_due_date = '', $second_due_date = '';
    public array $fees = [];
    public bool $isUnifastBeneficiary = false, $isFullPayment = false;

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
                    'setting' => Models\Setting::get(['id', 'downpayment_minimum_percentage'])->first(),
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

    public function computeDownpayment()
    {
        return $this->setting->downpayment_minimum_percentage / 100 * $this->grandTotal;
    }

    public function save()
    {
        if (! $this->isUnifastBeneficiary) {
            $this->validate([
                'isUnifastBeneficiary' => ['required'],
                'isFullPayment' => 'required_if:isUnifastBeneficiary,==,false|boolean',
                'first_due_date' => 'required_if:isUnifastBeneficiary,==,false|date|after:today',
                'second_due_date' => 'required_if:isFullPayment,==,false|date|after:first_due_date',
            ], [
                'first_due_date.required_if' => 'This field is required.',
                'first_due_date.after' => 'This field must be a date after today.',
                'second_due_date.required_if' => 'This field is required.',
                'second_due_date.after' => 'This field must be a date after midterm.',
            ]);
        }

        try {
            $this->fill([
                'assessment.isUnifastBeneficiary' => $this->isUnifastBeneficiary,
                'assessment.additional' => $this->additional,
                'assessment.grand_total' => $this->grandTotal,
                'assessment.balance' => $this->grandTotal,
                'assessment.downpayment' => $this->isUnifastBeneficiary ? 0 : $this->downpayment,
                'assessment.amount_due' => $this->amountDue,
                'assessment.isFullPayment' => $this->isUnifastBeneficiary ? null : $this->isFullPayment,
                'assessment.first_due_date' => $this->isUnifastBeneficiary ? null : $this->first_due_date,
                'assessment.second_due_date' => $this->isFullPayment ? null : (empty($this->second_due_date) ? null : $this->second_due_date),
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

            $this->downpayment = $this->computeDownpayment();

            $this->updatedIsFullPayment();

            $this->registration->refresh();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function cancel() { return
        $this->redirect(route('pre.registration.view', ['regId' => $this->registration->id]));
    }

    public function updatedAssessmentIsPercentage($value) {
        if (empty($value)) {
            $this->assessment->discount_amount = 0;
        } {
            $this->isFullPayment = ! $this->isFullPayment;
        }
    }

    public function updatedIsFullPayment() {
        $this->amountDue = (new AssessmentComputationService())->computeAmountDue($this->grandTotal, $this->downpayment, $this->isFullPayment);
    }
}
