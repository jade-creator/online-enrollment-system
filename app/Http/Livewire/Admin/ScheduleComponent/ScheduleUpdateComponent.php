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
    public array $schedules = [];
    public bool $viewingSchedule = false;
    public $prospectusSubjects, $days;

    protected $listeners = [ 'modalViewingSchedule' ];

    public function rules()
    {
        return [
            'schedule.subject_id' => ['required'],
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
        $this->authorize('update', $this->schedule);
        $this->validate();

        try {
            $schedule = (new Schedule\ScheduleService())->update($this->schedule, $this->schedules);

            $this->toggleViewingSchedule();
            $this->success($this->schedule->subject->code."'s time period in ".$this->section->name." has been updated.");
            $this->emitUp('refresh');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
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
        } catch (\Exception $e) {
            $this->toggleViewingSchedule();
            $this->error($e->getMessage());
        }
    }

    public function toggleViewingSchedule() {
        $this->viewingSchedule = !$this->viewingSchedule;
    }
}
