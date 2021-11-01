<?php

namespace App\Http\Livewire\Admin\ScheduleComponent;

use App\Models;
use App\Models\Curriculum;
use App\Services\Schedule;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ScheduleUpdateComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Employee $employee;
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

        $curriculum = Curriculum::findActiveCurriculum($this->section->prospectus->program_id);

        $this->toggleViewingSchedule();

        try {
            $this->authorize('update', $this->schedule);

            if ($this->schedule->created_at->gt($curriculum->created_at)) {
                $this->schedule = (new Schedule\ScheduleService())->updateProfSchedule($this->schedule, $this->profSchedules);
                (new Schedule\ScheduleService())->update($this->schedule, $this->schedules);
            } else {
                $schedule = new Models\Schedule();

                $schedule->prospectus_subject_id = $this->schedule->prospectus_subject_id;
                $schedule->employee_id = $this->schedule->employee_id;
                $schedule->day_id = $this->schedule->day_id;
                $schedule->start_time = $this->schedule->start_time;
                $schedule->end_time = $this->schedule->end_time;

                (new Schedule\ScheduleService())->store($this->section, $schedule, $this->days);

                $this->schedule->delete();
            }

            $this->emitUp('sessionFlashAlert', 'alert', 'success', "A schedule has been updated in ".$this->section->name);
        } catch (\Exception $e) {
            $this->schedule->day_id = $originalDayId;
            $this->schedule->update();

            $this->emitUp('sessionFlashAlert', 'alert', 'danger', $e->getMessage());
        }
    }

    public function modalViewingSchedule(Models\Section $section, Models\Schedule $schedule)
    {
        $this->resetValidation();

        $this->fill([
            'section' => $section,
            'schedule' => $schedule,
            'employee' => $schedule->employee,
            'prospectusSubjects' => Models\ProspectusSubject::getAllSubjectsInProspectus($section->prospectus->id)->unique('subject_id'),
        ]);

        $this->toggleViewingSchedule();

        try {
            $scheduleMergeabilityService = new Schedule\ScheduleMergeabilityService();

            $blocks = $scheduleMergeabilityService->populateBlocks($this->schedule);
            $this->schedules = $scheduleMergeabilityService->unsetSchedule($this->section, $blocks, $this->days);

            $employee = Models\Employee::with('schedules')->findOrFail($schedule->employee_id);
            $this->profSchedules = $scheduleMergeabilityService->unsetSchedule($employee, $blocks, $this->days);

        } catch (\Exception $e) {
            $this->emitUp('sessionFlashAlert', 'alert', 'danger', $e->getMessage());
        }
    }

    public function toggleViewingSchedule() {
        $this->viewingSchedule = !$this->viewingSchedule;
    }
}
