<?php

namespace App\Http\Livewire\Admin\ScheduleComponent;

use App\Models;
use App\Services\Schedule;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ScheduleUpdateComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Section $section;
    public Models\Schedule $schedule;
    public array $schedules = [], $profSchedules = [];
    public bool $viewingSchedule = false;
    public $prospectusSubjects, $days, $professors;

    protected $listeners = [ 'modalViewingSchedule' ];

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
        view('livewire.admin.schedule-component.schedule-update-component');
    }

    public function update()
    {
        $this->validate();

        $originalDayId = $this->schedule->getOriginal('day_id');
        try {
            $this->authorize('update', $this->schedule);
            $this->schedule = (new Schedule\ScheduleService())->updateProfSchedule($this->schedule, $this->profSchedules);
            $schedule = (new Schedule\ScheduleService())->update($this->schedule, $this->schedules);

            $this->emitUp('alertParent', 'success', $this->schedule->prospectusSubject->subject->code."'s time period in ".$this->section->name." has been updated.");
            $this->toggleViewingSchedule();
            $this->emitUp('refresh');
        } catch (\Exception $e) {
            $this->schedule->day_id = $originalDayId;
            $this->schedule->update();

            $this->toggleViewingSchedule();
            $this->emitUp('alertParent', 'danger', $e->getMessage());
        }
    }

    public function modalViewingSchedule(Models\Section $section, Models\Schedule $schedule)
    {
        $this->resetValidation();
        $this->fill([
            'section' => $section,
            'schedule' => $schedule,
            'prospectusSubjects' => Models\ProspectusSubject::getAllSubjectsInProspectus($section->prospectus->id),
        ]);
        $this->toggleViewingSchedule();

        try {
            $scheduleMergeabilityService = new Schedule\ScheduleMergeabilityService();

            $blocks = $scheduleMergeabilityService->populateBlocks($this->schedule);
            $this->schedules = $scheduleMergeabilityService->unsetSchedule($this->section, $blocks, $this->days);

            $employee = Models\Employee::with('schedules')->findOrFail($schedule->employee_id);
            $this->profSchedules = $scheduleMergeabilityService->unsetSchedule($employee, $blocks, $this->days);
        } catch (\Exception $e) {
            $this->toggleViewingSchedule();
            $this->error($e->getMessage());
        }
    }

    public function toggleViewingSchedule() {
        $this->viewingSchedule = !$this->viewingSchedule;
    }
}
