<?php

namespace App\Http\Livewire\Admin\PreEnrollmentComponent;

use App\Models\Registration;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class PreEnrollmentDestroyComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    protected $listeners = [
        'removeRegistration',
        'removeConfirm',
    ];

    public function render()
    {
        return <<<'blade'
            <div>
            </div>
        blade;
    }

    public function removeConfirm(Registration $registration) {
        $this->confirm('removeRegistration', 'Are you sure you want this deleted?', $registration);
    }

    public function removeRegistration(Registration $registration)
    {
        try {
            $this->authorize('destroy', $registration);
            $registration->delete();

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => 'Registration has been deleted.',
            ]);
            return redirect(route('admin.pre.enrollments.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
