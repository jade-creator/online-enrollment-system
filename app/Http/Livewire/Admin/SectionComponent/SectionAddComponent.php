<?php

namespace App\Http\Livewire\Admin\SectionComponent;

use App\Models;
use App\Services\Section\SectionService;
use App\Traits\WithSweetAlert;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SectionAddComponent extends Component
{
    use AuthorizesRequests;
    use WithSweetAlert;

    public Models\Section $section;
    public bool $addingSection = false;
    public string $programId = '', $levelId = '', $termId = '';
    public $rooms, $programs;

    protected  $listeners = ['modalAddingSection'];

    public function rules()
    {
        return [
            'section.name' => ['required', 'string'],
            'section.room_id' => ['required', 'integer'],
            'section.seat' => ['required', 'integer', 'min:1'],
            'programId' => ['required', 'integer'],
            'levelId' => ['required', 'integer'],
            'termId' => ['required', 'integer'],
        ];
    }

    public function render() { return
        view('livewire.admin.section-component.section-add-component');
    }

    public function modalAddingSection()
    {
        $this->resetValidation();
        $this->fill([
            'section' => new Models\Section(),
            'addingSection' => !$this->addingSection,
        ]);
    }

    public function save()
    {
        $this->authorize('create', Models\Section::class);
        $this->validate();

        try {
            (new SectionService())->store($this->programId, $this->levelId, $this->termId, $this->section);

            $this->emitUp('refresh');
            $this->success($this->section->name.' has been added.');
        }catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->modalAddingSection();
    }

    public function getLevelsProperty() { return
        Models\Level::get(['id', 'level']);
    }

    public function getTermsProperty() { return
        Models\Term::get(['id', 'term']);
    }
}
