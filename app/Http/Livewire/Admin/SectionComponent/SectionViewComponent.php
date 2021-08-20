<?php

namespace App\Http\Livewire\Admin\SectionComponent;

use App\Exports\SectionsExport;
use App\Http\Requests\ScheduleFormRequest;
use App\Models\Program;
use App\Models\Prospectus;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\SchoolType;
use App\Models\Section;
use App\Models\Status;
use App\Models\Term;
use App\Traits\WithBulkActions;
use App\Traits\WithExporting;
use App\Traits\WithFilters;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SectionViewComponent extends Component
{
    use AuthorizesRequests;
    use WithBulkActions, WithSorting, WithPagination, WithFilters, WithExporting;

    public Section $section;
    public Schedule $schedule;
    public Prospectus $prospectus;
    public int $paginateValue = 10, $currentNumberOfStudents = 0;
    public bool $addingSection = false, $viewingSection = false, $addingSchedule = false;
    public $levelId, $programId, $termId;
    public $registrations;

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
        'levelId' => [ 'except' => '' ],
        'programId' => [ 'except' => '' ],
        'termId' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'search',
        'levelId',
        'programId',
        'termId',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage', 'removeItem', 'releaseStudents'];

    protected array $allowedSorts = [
        'id',
        'name',
    ];

    public function rules()
    {
        return [
            'section.name' => ['required', 'string'],
            'section.room_id' => ['required', 'integer'],
            'section.seat' => ['required', 'integer', 'min:1', 'gte:currentNumberOfStudents'],
            'currentNumberOfStudents' => ['integer', 'min:0'],
        ];
    }

    public function mount() {
        $this->fill([
            'section' => new Section(),
            'schedule' => new Schedule(),
            'prospectus' => new Prospectus(),
            'registrations' => collect(),
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
        return Section::search($this->search)
            ->select(['id', 'name',  'prospectus_id', 'room_id', 'seat', 'created_at'])
            ->with([
                'prospectus:id,level_id,program_id,term_id',
                'schedules.subject',
                'room:id,name',
                'registrations' => function($query) {
                    $status = Status::where('name', 'enrolled')->first();
                    return $query->where('status_id', $status->id)
                                ->whereNull('released_at');
                }
            ])
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

    public function save()
    {
        $this->authorize('create', Section::class);
        $this->validate();

        $this->prospectus = Prospectus::select(['id'])
                    ->with('subjects')
                    ->when(!empty($this->levelId), function($query) {
                        return $query->where('level_id', $this->levelId);
                    })
                    ->when(!empty($this->programId), function($query) {
                        return $query->where('program_id', $this->programId);
                    })
                    ->when(!empty($this->termId), function($query) {
                        return $query->where('term_id', $this->termId);
                    })
                    ->firstOrFail();

        if ($this->prospectus->subjects->isEmpty()) {
            return $this->dispatchBrowserEvent('swal:modal', [
                'title' => "Warning",
                'type' => "error",
                'text' => "Please add subject/s first under this prospectus.",
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

        $this->resetFields(false);
    }

    //TODO : make it a trait.
    public function addingSection() {

        if (empty($this->levelId) || empty($this->programId) || empty($this->termId)) {
            return $this->dispatchBrowserEvent('swal:modal', [
                'title' => "Oops Sorry..",
                'type' => "error",
                'text' => "Please selected the necessary fields (Level, Program, and Term).",
            ]);
        }

        $this->resetFields(true);
    }

    public function viewSection(Section $section)
    {
        $this->fill([
            'section' => $section,
            'currentNumberOfStudents' => $section->registrations->count(),
            'viewingSection' => true,
        ]);
    }

    public function updateSection()
    {
        $this->authorize('update', $this->section);
        $this->validate();

        $this->section->save();
        $this->fill([ 'viewingSection' => false, ]);

        $this->dispatchBrowserEvent('swal:success', [
            'text' => "The section has been updated.",
        ]);
    }

    public function release()
    {
        $status = Status::where('name', 'released')->first();

        if ($this->registrations->count() > 0) {
            foreach ($this->registrations as $registration ) {
                $registration->status_id = $status->id;
                $registration->released_at = now();
                $registration->save();
            }
        }
    }

    public function releaseConfirm(Section $section)
    {
        $this->section = $section;

        $this->dispatchBrowserEvent('swal:confirmRelease', [
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => 'Students under this section will be removed. Their registration will moved to history once this action is successfull.',
        ]);
    }

    public function releaseStudents()
    {
        $this->registrations = $this->section->registrations;
        $this->release();

        $this->dispatchBrowserEvent('swal:success', [
            'text' => "The students have been released.",
        ]);
    }

    public function releaseAll()
    {
        $sections = Section::with(['registrations' => function($query) {
                    return $query->whereNull('released_at');
                }])
                ->whereIn('id', $this->selected)
                ->get();

        $sections->map(function($section) {
            $this->registrations = $section->registrations;
            $this->release();
        });

        $this->dispatchBrowserEvent('swal:success', [
            'text' => "The students have been released.",
        ]);
    }

    public function removeConfirm(Section $section) {
        $this->section = $section;

        if (!$this->section->registrations->isEmpty()) {
            return $this->dispatchBrowserEvent('swal:modal', [
                'title' => "Warning!",
                'type' => "warning",
                'text' => "There are students enrolled on this section.",
            ]);
        }

        $this->dispatchBrowserEvent('swal:confirmDelete', [
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => 'Please note that upon deletion it cannot be retrievable.',
        ]);
    }

    public function removeItem() { $this->section->delete(); }

    public function getRoomsProperty() { return
        Room::get(['id', 'name']);
    }

    public function getLevelsProperty()
    {
        $college = SchoolType::select(['id', 'type'])
            ->where('type', 'College')
            ->with('levels:id,level,school_type_id')
            ->first();

        return $college->levels;
    }

    public function getProgramsProperty() { return
        Program::get(['id', 'code']);
    }

    public function getTermsProperty() { return
        Term::get(['id', 'term']);
    }

    public function updatedViewingSection($value)
    {
        if (!$value) {
            $this->fill([ 'section' => new Section() ]);
        }
        $this->resetValidation();
    }

    public function updatedAddingSection() { $this->fill([ 'section' => new Section() ]); }

    public function updateSchedule(ScheduleFormRequest  $request)
    {
        $this->authorize('update', $this->schedule);
        $this->validate($request->rules());

        $this->schedule->save();

        $this->fill([ 'addingSchedule' => false ]);

        $this->dispatchBrowserEvent('swal:success', [
            'text' => "The schedule has been updated.",
        ]);
    }

    public function updatedAddingSchedule($value)
    {
        $this->authorize('create', Section::class);

        if (!$value) {
            $this->fill([
                'section' => new Section(),
                'schedule' => new Schedule(),
            ]);
        } else{
            $this->resetValidation();
            $this->fill([
                'schedule' => Schedule::find($value),
                'addingSchedule' => !$this->addingSchedule,
            ]);
        }
    }

    public function resetFields($bool) {
        $this->fill([
            'addingSection' => $bool,
            'section' => new Section(),
        ]);
    }

    public function updatedLevelId() { $this->resetPage(); } //TODO: reset program and term ids.

    public function updatingProgramId() { $this->resetPage(); }

    public function updatingTermId() { $this->resetPage(); }

    public function fileExport() { return
        $this->excelFileExport((new SectionsExport($this->selected)), 'section-collection.xlsx');
    }
}
