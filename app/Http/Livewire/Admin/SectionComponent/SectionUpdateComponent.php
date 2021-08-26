<?php

namespace App\Http\Livewire\Admin\SectionComponent;

use App\Models;
use App\Services\Section\SectionService;
use App\Traits\WithSweetAlert;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SectionUpdateComponent extends Component
{
    use AuthorizesRequests;
    use WithSweetAlert;

    public Models\Section $section;
    public int $currentNumberOfStudents = 0;
    public bool $viewingSection = false;
    public $rooms;

    protected $listeners = [ 'modalViewingSection' ];

    public function rules()
    {
        return [
            'section.name' => ['required', 'string'],
            'section.room_id' => ['required', 'integer'],
            'section.seat' => ['required', 'integer', 'min:1', 'gte:currentNumberOfStudents'],
            'currentNumberOfStudents' => ['integer', 'min:0'],
        ];
    }

    public function mount() { $this->setSection(new Models\Section()); }

    public function render() { return
        view('livewire.admin.section-component.section-update-component');
    }

    public function update()
    {
        $this->authorize('update', $this->section);
        $this->validate();

        try {
            $this->section = (new SectionService())->update($this->section);

            $this->emitUp('refresh');
            $this->success($this->section->name.' has been updated.');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->toggleViewingSection();
    }

    public function modalViewingSection(Models\Section $section)
    {
        $this->setSection($section);
        $this->currentNumberOfStudents = $this->section->registrations->count();
        $this->toggleViewingSection();
    }

    public function toggleViewingSection()
    {
        $this->resetValidation();
        $this->viewingSection = !$this->viewingSection;
    }

    public function setSection(Models\Section $section) { $this->section = $section; }
}
