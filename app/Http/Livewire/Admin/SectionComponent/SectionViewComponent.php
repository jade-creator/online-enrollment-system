<?php

namespace App\Http\Livewire\Admin\SectionComponent;

use App\Exports\SectionsExport;
use App\Models\Level;
use App\Models\Program;
use App\Models\Prospectus;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Section;
use App\Models\Strand;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithBulkActions;
use App\Traits\WithFilters;
use App\Traits\WithSorting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SectionViewComponent extends Component
{
    use AuthorizesRequests;
    use WithBulkActions, WithSorting, WithPagination, WithFilters;

    public Section $section;
    public Schedule $schedule;
    public int $paginateValue = 10;
    public bool $confirmingExport = false, $addingSection = false, $addingSchedule = false;
    public $prospectus, $levelId, $programId, $strandId, $termId, $typeId = 1;

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
        'levelId' => [ 'except' => '' ],
        'programId' => [ 'except' => '' ],
        'strandId' => [ 'except' => '' ],
        'termId' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'search',
        'levelId',
        'programId',
        'strandId',
        'termId',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage'];

    public function rules() 
    {
        return [
            'section.name' => ['required', 'string'],
            'section.remarks' => ['nullable', 'string'],
            'section.room_id' => ['required', 'integer'],
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

    protected array $allowedSorts = [
        'id',
        'name',
    ];

    public function mount() {
        $this->fill([ 
            'section' => new Section(),
            'schedule' => new Schedule(), 
        ]);
    }

    public function render() { return 
        view('livewire.admin.section-component.section-view-component', ['sections' => $this->rows]);
    }

    public function getRowsProperty() { return 
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return Section::select(['id', 'name', 'remarks', 'prospectus_id', 'room_id', 'created_at'])
            ->with(['prospectus:id,level_id,program_id,strand_id,term_id', 'schedules.subject', 'room:id,name'])
            ->when(!empty($this->levelId), function($query) {
                return $query->WhereHas('prospectus', function($query) {
                            return $query->where('level_id', $this->levelId);
                        });
            })
            ->when(!empty($this->programId), function($query) {
                return $query->WhereHas('prospectus', function($query) {
                            return $query->where('program_id', $this->programId);
                        });
            })
            ->when(!empty($this->strandId), function($query) {
                return $query->WhereHas('prospectus', function($query) {
                            return $query->where('strand_id', $this->strandId);
                        });
            })
            ->when(!empty($this->termId), function($query) {
                return $query->WhereHas('prospectus', function($query) {
                            return $query->where('term_id', $this->termId);
                        });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->when(!is_null($this->dateMin), function ($query) {
                return $query->whereBetween('created_at', [$this->dateMin, $this->dateMax]);
            });
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $this->prospectus = Prospectus::select(['id'])
                    ->with('subjects')
                    ->when(!empty($this->levelId), function($query) {
                        return $query->where('level_id', $this->levelId);
                    })
                    ->when(!empty($this->programId), function($query) {
                        return $query->where('program_id', $this->programId);
                    })
                    ->when(!empty($this->strandId), function($query) {
                        return $query->where('strand_id', $this->strandId);
                    })
                    ->when(!empty($this->termId), function($query) {
                        return $query->where('term_id', $this->termId);
                    })
                    ->firstOrFail();

        if ($this->prospectus->subjects->isEmpty()) {
            return \Debugbar::info([
                'error: ' => 'No subject included under this prospectus.'
            ]);
        }

        $this->section->prospectus_id = $this->prospectus->id;
        $this->section->save();

        $sectionId = $this->section->id;

        $this->prospectus->subjects->map(function ($subject) use ($sectionId) {
            $schedule = Schedule::create([
                'subject_id' => $subject->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $schedule->sections()->attach([$sectionId]);
        });

        $this->resetFields();
        $this->fill([ 'addingSection' => false ]);
    }

    public function addingSection() {

        if (empty($this->levelId)) {
            return \Debugbar::info([
                'error' => 'Level Id is required.'
            ]);
        }

        if ($this->levelId > 10 && empty($this->termId)) {
            return \Debugbar::info([
                'error' => 'term Id is required.'
            ]);
        }

        if ($this->levelId > 13 && empty($this->programId)) {
            return \Debugbar::info([
                'error' => 'program Id is required.'
            ]);
        } else if (($this->levelId > 10 && $this->levelId < 13) && empty($this->strandId)) {
            return \Debugbar::info([
                'error' => 'strand Id is required.'
            ]);
        }

        $this->fill([ 'addingSection' => true ]);
    }

    public function updateSchedule()
    {
        $this->authorize('create', Section::class);

        $this->validate([
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
        ]);

        $this->schedule->save();

        $this->resetFields();
        $this->fill([ 'addingSchedule' => false ]);
    }

    public function getRoomsProperty() { return
        Room::get(['id', 'name']);
    }

    public function getLevelsProperty() { return
        Level::get(['id', 'level']);
    }

    public function getProgramsProperty() { return
        Program::get(['id', 'code']);
    }

    public function getStrandsProperty() { return
        Strand::get(['id', 'code']);
    }

    public function updatedAddingSection($value) 
    {
        if (!$value) {
            $this->resetFields();
        }
    }

    public function updatedAddingSchedule($value) 
    {
        $this->authorize('create', Section::class);

        if (!$value) {
            $this->resetFields();
            $this->fill([ 'schedule' => new Schedule() ]);
        } else{
            $this->resetValidation();
            $this->fill([ 
                'schedule' => Schedule::find($value),
                'addingSchedule' => !$this->addingSchedule,
            ]);
        }
    }

    public function resetFields() {
        $this->fill([
            'section' => new Section(),
            'section.name' => '',
            'section.remarks' => null,
            'section.room_id' => '',
        ]);
    }

    public function updatedLevelId() 
    {
        $this->fill([
            'programId' => '',
            'strandId' => '',
            'termId' => '',
        ]);

        $this->resetPage();
    }

    public function updatingProgramId() { $this->resetPage(); }

    public function updatingTrackId() { $this->resetPage(); }

    public function updatingStrandId() { $this->resetPage(); }

    public function updatingTermId() { $this->resetPage(); }

    public function fileExport() 
    {
        $this->confirmingExport = false;
        return (new SectionsExport($this->selected))->download('sections-collection.xlsx');
    }    

    public function paginationView() { return 
        'partials.pagination-link'; 
    }
}
