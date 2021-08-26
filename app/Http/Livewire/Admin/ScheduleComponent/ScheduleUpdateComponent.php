<?php

namespace App\Http\Livewire\Admin\ScheduleComponent;

use App\Models\Schedule;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ScheduleUpdateComponent extends Component
{
    use AuthorizesRequests;
    use WithSweetAlert;

    public Schedule $schedule;
    public bool $viewingSchedule = false;

    protected $listeners = [ 'modalViewingSchedule' ];

    public function rules()
    {
        return [
            'schedule.start_time_monday' => ['nullable'],
            'schedule.end_time_monday' => ['nullable', 'after:schedule.start_time_monday'],
            'schedule.start_time_tuesday' => ['nullable'],
            'schedule.end_time_tuesday' => ['nullable', 'after:schedule.start_time_tuesday'],
            'schedule.start_time_wednesday' => ['nullable'],
            'schedule.end_time_wednesday' => ['nullable', 'after:schedule.start_time_wednesday'],
            'schedule.start_time_thursday' => ['nullable'],
            'schedule.end_time_thursday' => ['nullable', 'after:schedule.start_time_thursday'],
            'schedule.start_time_friday' => ['nullable'],
            'schedule.end_time_friday' => ['nullable', 'after:schedule.start_time_friday'],
        ];
    }

    public function mount() { $this->setSchedule(new Schedule()); }

    public function render() { return
        view('livewire.admin.schedule-component.schedule-update-component');
    }

    public function update()
    {
        $this->authorize('update', $this->schedule);
        $this->validate();

        try {
            $this->schedule->update();
            $this->emitUp('refresh');
            $this->success($this->schedule->subject->code." has been updated.");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->toggleViewingSchedule();
    }

    public function modalViewingSchedule(Schedule $schedule)
    {
        $this->setSchedule($schedule);
        $this->toggleViewingSchedule();
    }

    public function toggleViewingSchedule()
    {
        $this->resetValidation();
        $this->viewingSchedule = !$this->viewingSchedule;
    }

    public function setSchedule(Schedule $schedule) { $this->schedule = $schedule; }
}
