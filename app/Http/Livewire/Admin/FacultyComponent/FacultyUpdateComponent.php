<?php

namespace App\Http\Livewire\Admin\FacultyComponent;

use App\Models\Faculty;
use App\Models\Program;
use App\Services\Faculty\FacultyService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class FacultyUpdateComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Faculty $faculty;
    public $route;

    public function rules()
    {
        return [
            'faculty.code' => ['required', 'string', 'max:100', 'unique:faculties,code,'.$this->faculty->id, 'alpha_dash'],
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
        $this->route = url()->previous();
    }

    public function render() { return
        view('livewire.admin.faculty-component.faculty-update-component');
    }

    public function update()
    {
        $this->validate();

        try {
            $this->authorize('update', $this->faculty);
            $faculty = (new FacultyService())->update($this->faculty);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $faculty->name.' has been updated.',
            ]);

            return redirect($this->route);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
