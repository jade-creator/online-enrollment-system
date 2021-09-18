<?php

namespace App\Http\Livewire\Partials;

use App\Models;
use App\Services\Registration\RegistrationService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SelectSectionForm extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Registration $registration;
    public bool $addingClasses = false;
    public $sectionId = '', $sections, $schedules;

    protected $listeners = [ 'modalAddingClasses' ];

    public function rules() {
        return [
            'sectionId' => ['required'],
        ];
    }

    public function mount() {
        $this->fill([
            'registration' => new Models\Registration(),
            'sections' => collect(),
            'schedules' => collect(),
        ]);
    }

    public function render() { return
        view('livewire.partials.select-section-form');
    }

    public function save()
    {
        $this->validate();

        try {
            $this->authorize('selectSection', $this->registration);
            $registration = (new RegistrationService())->selectSection($this->registration, $this->sectionId, $this->schedules);

            $this->toggleModal();
            $this->success('Registration has been updated');
            $this->emitUp('refresh');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function modalAddingClasses(Models\Registration $registration)
    {
        $this->resetValidation();
        $this->fill([
            'sectionId' => '',
            'registration' => $registration,
            'sections' => $registration->prospectus->sections,
            'schedules' => collect(),
        ]);
        $this->toggleModal();
    }

    public function toggleModal() { return
        $this->addingClasses = !$this->addingClasses;
    }

    public function updatedSectionId() {
        $this->schedules = Models\Schedule::with([
            'prospectusSubject.subject',
            'day',
        ])->where('section_id', $this->sectionId)->get();
    }
}
