<?php

namespace App\Http\Livewire\Admin\FacultyComponent;

use App\Models\Faculty;
use App\Models\Program;
use App\Services\Faculty\FacultyService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class FacultyAddComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Faculty $faculty;

    public function rules()
    {
        return [
            'faculty.code' => ['required', 'string', 'max:100', 'unique:faculties,code', 'alpha_dash'],
            'faculty.name' => ['required', 'string', 'max:200'],
            'faculty.description' => ['required', 'string', 'max:500'],
            'faculty.mission' => ['required', 'string', 'max:500'],
            'faculty.vision' => ['required', 'string', 'max:500'],
        ];
    }

    protected $messages = [
        'faculty.code.required' => 'The code field cannot be empty.',
        'faculty.name.required' => 'The name field cannot be empty.',
        'faculty.description.required' => 'The description field cannot be empty.',
        'faculty.mission.required' => 'The mission field cannot be empty.',
        'faculty.vision.required' => 'The vision field cannot be empty.',
    ];

    public function mount() {
        $this->faculty = new Faculty();
    }

    public function render() { return
        view('livewire.admin.faculty-component.faculty-add-component');
    }

    public function save()
    {
        $this->validate();

        try {
            $this->authorize('create', Faculty::class);
            (new FacultyService())->store($this->faculty);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $this->faculty->name.' has been added.',
            ]);
            return redirect(route('admin.faculties.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
