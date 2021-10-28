<?php

namespace App\Http\Livewire\Admin\ScheduleComponent;

use App\Models;
use App\Services\Schedule\ScheduleService;
use App\Traits\WithFilters;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class ScheduleAddComponent extends Component
{
    use AuthorizesRequests;
    use WithPagination, WithSweetAlert, WithFilters;

    public Models\Section $section;
    public Models\Schedule $schedule;
    public bool $addingSchedule = false;
    public int $paginateValue = 10;
    public array $employee = [];
    public string $employeeId = '';
    public $prospectusSubjects, $days;

    protected $listeners = [ 'modalAddingSchedule' ];

    protected $messages = [
        'schedule.prospectus_subject_id.required' => 'The subject field cannot be empty.',
        'schedule.day_id.required' => 'The day field cannot be empty.',
        'schedule.start_time.required' => 'The start time field cannot be empty.',
        'schedule.end_time.required' => 'The end time field cannot be empty.',
    ];

    public function rules()
    {
        return [
            'schedule.prospectus_subject_id' => ['required'],
            'schedule.day_id' => ['required'],
            'schedule.start_time' => ['required'],
            'schedule.end_time' => ['required', 'after:schedule.start_time'],
        ];
    }

    public function mount() {
        $this->prospectusSubjects = collect();
    }

    public function render() { return
        view('livewire.admin.schedule-component.schedule-add-component', ['professors' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty() { return
        Models\Employee::search($this->search)
            ->with('user.person')
            ->whereHas('user', function ($query){
                return $query->orWhere('role_id', '>', 3);
            })
            ->when(filled($this->search), function ($query) {
                $query->orWhereHas('user.person', function ($query) {
                    $query->where('firstname', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('middlename', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('lastname', 'LIKE', '%'.$this->search.'%');
                });
            });
    }

    public function save()
    {
        $this->validate();

        $this->toggleAddingSchedule();
        try {
            $this->authorize('createClass', $this->section);

            $this->schedule->employee_id = $this->employee['id'];
            (new ScheduleService())->store($this->section, $this->schedule, $this->days);

            $this->emitUp('sessionFlashAlert', 'alert', 'success', "A class has been added in ".$this->section->name);
        } catch (\Exception $e) {
            $this->emitUp('sessionFlashAlert', 'alert', 'danger', $e->getMessage());
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

    public function updatedAddingSchedule($value) {
        if (! $value) $this->reset('employee');
    }
}
