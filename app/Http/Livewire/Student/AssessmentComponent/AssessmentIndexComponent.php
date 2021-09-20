<?php

namespace App\Http\Livewire\Student\AssessmentComponent;

use App\Models\Registration;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class AssessmentIndexComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Registration $registration;

    public function render() { return
        view('livewire.student.assessment-component.assessment-index-component');
    }
}
