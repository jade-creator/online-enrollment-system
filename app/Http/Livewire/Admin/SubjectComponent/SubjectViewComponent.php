<?php

namespace App\Http\Livewire\Admin\SubjectComponent;

use App\Exports\SubjectsExport;
use App\Models\Subject;
use App\Traits\WithBulkActions;
use App\Traits\WithFilters;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class SubjectViewComponent extends Component
{
    use WithBulkActions, WithSorting, WithPagination, WithFilters;

    public Subject $subject;
    public int $paginateValue = 10;
    public bool $confirmingExport = false, $addingSubject = false;
    public $availableSubjects = [], $preRequisites = [];

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

    protected $listeners = ['DeselectPage' => 'updatedSelectPage'];

    public function rules() 
    {
        return [
            'subject.code' => ['required', 'string', 'max:255'],
            'subject.title' => ['required', 'string', 'max:255'],
            'subject.unit' => ['required', 'integer', 'min:0'],
        ];     
    }

    protected array $allowedSorts = [
        'code',
        'title',
    ];

    public function mount() 
    {
        $this->addSubject();
        $this->fill([ 
            'subject' => new Subject(),
        ]);
    }

    public function render() { return 
        view('livewire.admin.subject-component.subject-view-component', ['subjects' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }    

    public function getRowsQueryProperty() 
    {
        return Subject::search($this->search)
            ->select(['id', 'code', 'title', 'unit', 'created_at'])
            ->with('requisites')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->when(!is_null($this->dateMin),
                fn ($query) => $query->whereBetween('created_at', [$this->dateMin, $this->dateMax]));
    }

    public function getSubjectsProperty() {
        $this->availableSubjects = Subject::get(['id', 'code']);
        return $this->availableSubjects;
    }

    public function addSubject() 
    {
        $this->preRequisites[] = '';
    }

    public function removeSubject($index) 
    {
        unset($this->preRequisites[$index]);
        array_values($this->preRequisites);
    }

    public function resetSubjects() 
    {
        $this->preRequisites= [''];
    }

    public function save() 
    {
        $this->validate();

        $this->preRequisites = array_filter($this->preRequisites);
        $this->preRequisites = array_unique($this->preRequisites);
        
        $this->subject->save();
        $this->subject->requisites()->attach($this->preRequisites);

        $this->fill([ 'addingSubject' => false ]);
    }

    public function updatingPaginateValue() { $this->resetPage(); }

    public function fileExport() 
    {
        $this->confirmingExport = false;
        return (new SubjectsExport($this->selected))->download('subjects-collection.xlsx');
    }    

    public function paginationView() { return 
        'partials.pagination-link'; 
    }
}
