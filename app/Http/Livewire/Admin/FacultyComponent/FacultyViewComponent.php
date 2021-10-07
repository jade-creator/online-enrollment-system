<?php

namespace App\Http\Livewire\Admin\FacultyComponent;

use App\Models\Employee;
use App\Models\Faculty;
use App\Services\Faculty\FacultyMemberService;
use App\Services\Faculty\FacultyService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class FacultyViewComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Faculty $faculty;

    protected $listeners = [
        'removeMember',
    ];

    public function render() { return
        view('livewire.admin.faculty-component.faculty-view-component');
    }

    public function leaveConfirm(Employee $employee) {
        $this->confirm('removeMember', 'Are you sure you want to leave?', $employee);
    }

    public function removeMemberConfirm(Employee $employee) {
        $this->confirm('removeMember', 'Are you sure you to remove this member?', $employee);
    }

    public function removeMember(Employee $employee)
    {
        try {
            $employee = (new FacultyMemberService())->remove($employee);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $employee->user->person->full_name.' has been removed.',
            ]);
            return redirect(route('admin.faculties.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
