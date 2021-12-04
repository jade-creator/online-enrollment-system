<?php

namespace App\Http\Livewire\Admin\SectionComponent;

use App\Models;
use App\Services\Section\SectionService;
use App\Traits\WithSweetAlert;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SectionUpdateComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Section $section;
    public $currentNumberOfStudents;
    public string $programId = '', $levelId = '', $termId = '';
    public $route;

    public function rules()
    {
        return [
            'section.name' => ['required', 'string', 'max:100', 'alpha_dash'],
            'section.room_id' => ['required', 'integer'],
            'currentNumberOfStudents' => ['integer', 'min:0'],
            'programId' => ['required'],
            'levelId' => ['required'],
            'termId' => ['required'],
        ];
    }

    protected $messages = [
        'section.name.required' => 'The name field cannot be empty.',
        'section.name.alpha_dash' => 'The name may only contain letters, numbers, dashes and underscores with no spaces.',
        'section.room_id.required' => 'The room field cannot be empty.',
        'programId.required' => 'The program field cannot be empty.',
        'levelId.required' => 'The level field cannot be empty.',
        'termId.required' => 'The term field cannot be empty.',
    ];

    public function mount()
    {
        $this->fill([
            'route' => url()->previous(),
            'programId' => $this->section->prospectus->program_id,
            'levelId' => $this->section->prospectus->level_id,
            'termId' => $this->section->prospectus->term_id,
            'currentNumberOfStudents' => $this->section->registrations()->enrolled()->count(),
        ]);
    }

    public function render() { return
        view('livewire.admin.section-component.section-update-component');
    }

    public function update()
    {
        $this->validate();

        try {
            $this->authorize('update', $this->section);
            $this->section = (new SectionService())->update($this->programId, $this->levelId, $this->termId, $this->section);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $this->section->name.' has been updated.',
            ]);

            return redirect($this->route);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function getRoomsProperty() { return
        Models\Room::get(['id', 'name']);
    }

    public function getProgramsProperty() { return
        Models\Program::get(['id', 'code']);
    }

    public function getLevelsProperty()
    {
        $schoolType = Models\SchoolType::with('levels')->where('type', 'College')->first();
        return $schoolType->levels;
    }

    public function getTermsProperty() { return
        Models\Term::get(['id', 'term']);
    }
}
