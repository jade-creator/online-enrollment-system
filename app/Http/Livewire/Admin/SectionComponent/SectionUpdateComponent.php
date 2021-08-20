<?php

namespace App\Http\Livewire\Admin\SectionComponent;

use App\Models;
use App\Services\Section\SectionService;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SectionUpdateComponent extends Component
{
    use AuthorizesRequests;

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

            $this->dispatchBrowserEvent('swal:success', [
                'text' => $this->section->name." has been updated.",
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', [
                'title' => "Warning",
                'type' => "error",
                'text' => $e->getMessage(),
            ]);
        }

        $this->modalViewingSection($this->section);
    }

    public function modalViewingSection(Models\Section $section)
    {
        $this->setSection($section);

        $this->resetValidation();
        $this->fill([
            'currentNumberOfStudents' => $this->section->registrations->count(),
            'viewingSection' => !$this->viewingSection,
        ]);
    }

    public function setSection(Models\Section $section) { $this->section = $section; }
}
