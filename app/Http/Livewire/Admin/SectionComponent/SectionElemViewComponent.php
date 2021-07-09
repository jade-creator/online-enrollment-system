<?php

namespace App\Http\Livewire\Admin\SectionComponent;

use App\Models\Level;
use App\Models\Room;
use App\Models\Section;
use App\Models\Strand;
use App\Models\Prospectus;
use App\Models\Program;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithBulkActions;
use App\Traits\WithFilters;
use App\Traits\WithSorting;

class SectionElemViewComponent extends Component
{
    use WithBulkActions, WithSorting, WithPagination, WithFilters;

    public Section $section;
    public int $paginateValue = 10;
    public bool $confirmingExport = false, $addingSection = false;
    public $prospectus, $levelId;

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
        'levelId' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'search',
        'levelId',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage'];

    public function rules() 
    {
        return [
            'section.name' => ['required', 'string'],
            'section.remarks' => ['nullable', 'string'],
            'section.room_id' => ['required', 'integer'],
        ];
    }

    protected array $allowedSorts = [
        'id',
        'name',
    ];

    public function mount() {
        $level = $this->levels->first();

        $this->fill([ 
            'section' => new Section(), 
            'levelId' =>  $level->id,
        ]);
    }

    public function render() { return 
        view('livewire.admin.section-component.section-elem-view-component', ['prospectus' => $this->rows]);
    }

    public function getRowsProperty() { return 
        $this->rowsQuery->paginate($this->paginateValue); 
    }

    public function dehydrate() {
        $this->fill([ 'levelId' => $this->prospectus->level_id ]);
    }

    public function getRowsQueryProperty()
    {
        $this->prospectus = Prospectus::select(['id', 'level_id', 'program_id', 'strand_id', 'term_id'])
            ->with('sections.room')
            ->where('level_id', $this->levelId)
            ->first();

            // $this->fill([
            //     'levelId' => $this->prospectus->level_id,
            //     'programId' => $this->prospectus->program_id ?? '',
            //     'strandId' => $this->prospectus->strand_id ?? '',
            //     'termId' => $this->prospectus->term_id ?? '',
            // ]);

        // \Debugbar::info($this->prospectus);

        return $this->prospectus->sections;
    }

    public function save()
    {
        $this->validate();
        $this->section->prospectus_id = $this->prospectus->id;
        $this->section->save();

        $this->fill([ 'addingSection' => false ]);
    }

    public function getRoomsProperty() { return
        Room::get(['id', 'name']);
    }

    public function getLevelsProperty() { return
        Level::where('school_type_id', 1)
            ->get(['id', 'level']);
    }

    public function getProgramsProperty() { return
        Program::get(['id', 'code']);
    }

    public function getStrandsProperty() { return
        Strand::get(['id', 'code']);
    }

    // public function getSchoolTypesProperty() { return
    //     SchoolType::get(['id', 'type']);
    // }

    public function updatingLevelId() {
        $this->fill([
            'programId' => '',
            'strandId' => '',
            'termId' => '',
        ]);

        $this->resetPage();
    }

    public function updatingPaginateValue() { $this->resetPage(); }

    public function fileExport() 
    {
        $this->confirmingExport = false;
        // return (new UsersExport($this->checkedUsers))->download('users-collection.xlsx');
    }    

    public function paginationView() { return 
        'partials.pagination-link'; 
    }
}
