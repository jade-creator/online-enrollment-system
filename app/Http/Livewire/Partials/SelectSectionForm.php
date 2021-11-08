<?php

namespace App\Http\Livewire\Partials;

use App\Models;
use App\Services\Registration\RegistrationService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SelectSectionForm extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public ?Models\Section $section = NULL;
    public Models\Registration $registration;
    public bool $addingClasses = false;
    public $sectionId = '', $sections, $schedules, $days;

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
            'days' => collect(),
            'schedules' => collect(),
        ]);
    }

    public function render() { return
        view('livewire.partials.select-section-form');
    }

    public function saveSchedule()
    {
        $this->validate();

        $this->toggleModal();

        try {
            $this->authorize('selectSection', $this->registration);
            $registration = (new RegistrationService())->selectSection($this->registration, $this->sectionId, $this->schedules);

            $this->emitUp( 'sessionFlashAlert', 'alert', 'success', 'section successfully updated.');
        } catch (\Exception $e) {
            $this->emitUp( 'sessionFlashAlert', 'alert', 'danger', $e->getMessage());
        }
    }

    public function modalAddingClasses(Models\Registration $registration)
    {
        $prospectus = $registration->prospectus()->with([
            'sections.registrations' => function ($query) {
                $query->where('status_id', 4)
                    ->whereNotNull('section_id')
                    ->whereNull('released_at');
            },
            'sections.days'
        ])->get();

        $this->resetValidation();
        $this->fill([
            'sectionId' => '',
            'registration' => $registration,
            'sections' => $prospectus->first()->sections->filter(function ($section) {
                return $section->schedules->isNotEmpty();
            }),
            'days' => collect(),
            'schedules' => collect(),
        ]);

        $this->toggleModal();
    }

    public function toggleModal() {
        $this->addingClasses = !$this->addingClasses;
    }

    public function updatedAddingClasses($value) {
        if (! $value) $this->reset(['sectionId', 'section']);
    }

    public function updatedSectionId($value) {
        if (empty($value)) return $this->fill([
            'section' => NULL,
            'days' => collect(),
            'schedules' => collect(),
        ]);

        $this->days = Models\Day::with([
                'schedules' => function ($query) {
                    $results = $query->where('section_id', $this->sectionId)
                        ->orderBy('start_time', 'asc')
                        ->get();

                    return $results->groupBy(['prospectus_subject_id', 'section_id', 'day_id']);
                },
            ])
            ->has('schedules')
            ->get();

        $this->schedules = Models\Schedule::with([
                'prospectusSubject.subject' => function ($query) { $query->withTrashed(); },
                'day',
            ])
            ->where('section_id', $this->sectionId)
            ->get();

        if ($this->days->isNotEmpty()) $this->section = $this->days->first(function ($day) {
            return $day->schedules->isNotEmpty();
        })->schedules->first()->section ?? NULL;
    }
}
