<?php

namespace App\Http\Livewire\Admin\SectionComponent;

use App\Models\Schedule;
use App\Models\Section;
use App\Services\Schedule\ScheduleService;
use App\Services\Section\SectionService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SectionDestroyComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    protected $listeners = [
        'removeSection',
        'removeConfirm',
        'removeScheduleConfirm',
        'removeSchedule',
    ];

    public function render()
    {
        return <<<'blade'
            <div>
            </div>
        blade;
    }

    public function removeConfirm(Section $section)
    {
        if ($section->registrations()->enrolled()->count() > 0) return $this->warning("Not allowed! There are students enrolled under ".$section->name);

        $this->confirm('removeSection', 'Are you sure you want this deleted?', $section);
    }

    public function removeSection(Section $section)
    {
        try {
            $this->authorize('destroy', $section);
            $section = (new SectionService())->destroy($section);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $section->name.' has been deleted.',
            ]);
            return redirect(route('sections.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function removeScheduleConfirm(Schedule $schedule) {
        $this->confirm('removeSchedule', 'Are you sure you want this deleted?', $schedule);
    }

    public function removeSchedule(Schedule $schedule)
    {
        try {
            $sectionName = $schedule->section->name;
            $this->authorize('destroy', $schedule);
            (new ScheduleService())->destroy($schedule);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => 'A class schedule has been removed in '.$sectionName,
            ]);
            return redirect(route('sections.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
