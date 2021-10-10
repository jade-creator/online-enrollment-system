<?php

namespace App\Http\Livewire\Admin\ScheduleComponent;

use App\Models;
use App\Services\Schedule\ScheduleService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ScheduleAddComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Section $section;
    public Models\Schedule $schedule;
    public bool $addingSchedule = false;
    public $prospectusSubjects, $days, $professors;

    protected $listeners = [ 'modalAddingSchedule' ];

    public function rules()
    {
        return [
            'schedule.prospectus_subject_id' => ['required'],
            'schedule.employee_id' => ['required'],
            'schedule.day_id' => ['required'],
            'schedule.start_time' => ['required'],
            'schedule.end_time' => ['required', 'after:schedule.start_time'],
        ];
    }

    public function mount() {
        $this->prospectusSubjects = collect();
    }

    public function render() { return
        view('livewire.admin.schedule-component.schedule-add-component');
    }

    public function save()
    {
        $this->validate();

        try {
            $this->authorize('createClass', $this->section);
            (new ScheduleService())->store($this->section, $this->schedule, $this->days);

            $this->success("A class has been added in ".$this->section->name);
            $this->toggleAddingSchedule();
            $this->emitUp('refresh');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function modalAddingSchedule(Models\Section $section)
    {
        $this->resetValidation();
        $this->fill([
            'section' => $section,
            'schedule' => new Models\Schedule(),
            'prospectusSubjects' => Models\ProspectusSubject::getAllSubjectsInProspectus($section->prospectus->id),
        ]);
        $this->toggleAddingSchedule();
    }

    public function toggleAddingSchedule() {
        $this->addingSchedule = !$this->addingSchedule;
    }
}
