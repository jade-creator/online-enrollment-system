<?php

namespace App\Http\Livewire\Admin\FacultyComponent;

use App\Models\Faculty;
use App\Services\Faculty\FacultyService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class FacultyDestroyComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    protected $listeners = [
        'removeFaculty',
        'removeConfirm',
    ];

    public function render()
    {
        return <<<'blade'
            <div>
            </div>
        blade;
    }

    public function removeConfirm(Faculty $faculty) {
        $this->confirm('removeFaculty', 'Are you sure you want this deleted?', $faculty);
    }

    public function removeFaculty(Faculty $faculty)
    {
        try {
            $this->authorize('destroy', $faculty);
            $faculty = (new FacultyService())->destroy($faculty);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $faculty->name.' has been deleted.',
            ]);
            return redirect(route('admin.faculties.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
