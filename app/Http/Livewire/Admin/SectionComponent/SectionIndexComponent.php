<?php

namespace App\Http\Livewire\Admin\SectionComponent;

use App\Exports\SectionsExport;
use App\Models;
use App\Traits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire;

class SectionIndexComponent extends Livewire\Component
{
    use AuthorizesRequests;
    use Livewire\WithPagination, Traits\WithBulkActions, Traits\WithSorting, Traits\WithFilters, Traits\WithExporting;

    public Models\Section $section;
    public int $paginateValue = 10, $currentNumberOfStudents = 0;
    public string $prospectusId = '';
//    public bool $addingSection = false, $viewingSection = false, $addingSchedule = false;
    public $registrations;

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
    ];

    protected $updatesQueryString = [
        'search',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage', 'setProspectusId', 'releaseStudents'];

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
            'section' => new Models\Section(),
            'registrations' => collect(),
        ]);
    }

    public function render() { return
        view('livewire.admin.section-component.section-index-component', ['sections' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return Models\Section::search($this->search)
            ->select(['id', 'name', 'prospectus_id', 'room_id', 'seat', 'created_at'])
            ->with([
                'schedules.subject',
                'registrations' => function($query) {
                    return $query->enrolled();
                },
            ])
            ->when(filled($this->prospectusId), function($query) {
                return $query->where('prospectus_id', $this->prospectusId);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->dateFiltered($this->dateMin, $this->dateMax);
    }

    public function setProspectusId($value) { $this->prospectusId = $value; }

    public function updatedProspectusId(){ $this->resetPage(); }

    public function save()
    {
//        $this->authorize('create', Models\Section::class);
//        $this->validate();
//
//        $this->prospectus = Models\Prospectus::select(['id'])
//            ->with('subjects')
//            ->when(!empty($this->levelId), function($query) {
//                return $query->where('level_id', $this->levelId);
//            })
//            ->when(!empty($this->programId), function($query) {
//                return $query->where('program_id', $this->programId);
//            })
//            ->when(!empty($this->termId), function($query) {
//                return $query->where('term_id', $this->termId);
//            })
//            ->firstOrFail();
//
//        if ($this->prospectus->subjects->isEmpty()) {
//            return $this->dispatchBrowserEvent('swal:modal', [
//                'title' => "Warning",
//                'type' => "error",
//                'text' => "Please add subject/s first under this prospectus.",
//            ]);
//        }
//
//        $this->section->prospectus_id = $this->prospectus->id;
//        $this->section->save();
//
//        $sectionId = $this->section->id;
//
//        $this->prospectus->subjects->map(function ($subject) use ($sectionId) {
//            $schedule = Models\Schedule::create([
//                'subject_id' => $subject->id,
//                'created_at' => now(),
//                'updated_at' => now(),
//            ]);
//
//            $schedule->sections()->attach([$sectionId]);
//        });

//        $this->resetFields(false);
    }

    //TODO : make it a trait.
//    public function addingSection() {
//
//        if (empty($this->levelId) || empty($this->programId) || empty($this->termId)) {
//            return $this->dispatchBrowserEvent('swal:modal', [
//                'title' => "Oops Sorry..",
//                'type' => "error",
//                'text' => "Please selected the necessary fields (Level, Program, and Term).",
//            ]);
//        }
//
//        $this->resetFields(true);
//    }
    //TODO : test
    public function viewSection(Models\Section $section)
    {
        \Debugbar::info($section);
//        $this->fill([
//            'section' => $section,
//            'currentNumberOfStudents' => $section->registrations->count(),
//            'viewingSection' => true,
//        ]);
    }

//    public function updateSection()
//    {
//        $this->authorize('update', $this->section);
//        $this->validate();
//
//        $this->section->save();
//        $this->fill([ 'viewingSection' => false, ]);
//
//        $this->dispatchBrowserEvent('swal:success', [
//            'text' => "The section has been updated.",
//        ]);
//    }

//    public function getRoomsProperty() { return
//        Models\Room::get(['id', 'name']);
//    }

//    public function getLevelsProperty()
//    {
//        $college = Models\SchoolType::select(['id', 'type'])
//            ->where('type', 'College')
//            ->with('levels:id,level,school_type_id')
//            ->first();
//
//        return $college->levels;
//    }

//    public function getProgramsProperty() { return
//        Models\Program::get(['id', 'code']);
//    }

//    public function getTermsProperty() { return
//        Models\Term::get(['id', 'term']);
//    }

//    public function updatedViewingSection($value)
//    {
//        if (!$value) {
//            $this->fill([ 'section' => new Models\Section() ]);
//        }
//        $this->resetValidation();
//    }

//    public function updatedAddingSection() { $this->fill([ 'section' => new Models\Section() ]); }

//    public function resetFields($bool) {
//        $this->fill([
//            'addingSection' => $bool,
//            'section' => new Models\Section(),
//        ]);
//    }

    public function fileExport() { return
        $this->excelFileExport((new SectionsExport($this->selected)), 'section-collection.xlsx');
    }
}
