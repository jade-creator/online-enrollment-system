<?php

namespace App\Http\Livewire\Admin\SectionComponent;

use App\Models;
use App\Services\Section\SectionService;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SectionAddComponent extends Component
{
    use AuthorizesRequests;

    public Models\Section $section;
    public bool $addingSection = false;
    public $rooms;

    protected  $listeners = ['modalAddingSection'];

    public function rules()
    {
        return [
            'section.name' => ['required', 'string'],
            'section.room_id' => ['required', 'integer'],
            'section.seat' => ['required', 'integer', 'min:1'],
            'section.prospectus_id' => ['required', 'integer'],
        ];
    }

    public function render() { return
        view('livewire.admin.section-component.section-add-component');
    }

    public function modalAddingSection($prospectusId = null)
    {
        $this->resetValidation();
        $this->fill([
            'section' => new Models\Section(),
            'addingSection' => !$this->addingSection,
            'section.prospectus_id' => $prospectusId,
        ]);
    }

    public function save()
    {
        $this->authorize('create', Models\Section::class);
        $this->validate();

        try {
            (new SectionService())->store($this->section);

            $this->emitUp('refresh');
            $this->dispatchBrowserEvent('swal:success', [
                'text' => "Section has been added.",
            ]);
        }catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', [
                'title' => "Warning",
                'type' => "error",
                'text' => $e->getMessage(),
            ]);
        }

        $this->modalAddingSection();
    }
}
