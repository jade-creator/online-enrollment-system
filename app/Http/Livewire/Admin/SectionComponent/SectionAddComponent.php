<?php

namespace App\Http\Livewire\Admin\SectionComponent;

use App\Models;
use App\Services\Section\SectionService;
use App\Traits\WithSweetAlert;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SectionAddComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Section $section;
    public string $programId = '', $levelId = '', $termId = '';

    protected $messages = [
        'section.name.required' => 'The name field cannot be empty.',
        'section.name.alpha_dash' => 'The name may only contain letters, numbers, dashes and underscores with no spaces.',
        'section.room_id.required' => 'The room field cannot be empty.',
        'programId.required' => 'The program field cannot be empty.',
        'levelId.required' => 'The level field cannot be empty.',
        'termId.required' => 'The term field cannot be empty.',
    ];

    public function rules()
    {
        return [
            'section.name' => ['required', 'string', 'max:100', 'alpha_dash'],
            'section.room_id' => ['required'],
            'programId' => ['required'],
            'levelId' => ['required'],
            'termId' => ['required'],
        ];
    }

    public function mount() {
        $this->section = new Models\Section();
    }

    public function render() { return
        view('livewire.admin.section-component.section-add-component');
    }

    public function save()
    {
        $this->validate();

        try {
            $this->authorize('create', Models\Section::class);
            $this->section = (new SectionService())->store($this->programId, $this->levelId, $this->termId, $this->section);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $this->section->name.' has been added.',
            ]);
            return redirect(route('sections.view'));
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
