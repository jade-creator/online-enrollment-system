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
    public bool $confirmingExport = false, $addingSubject = false, $viewingSubject = false;
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

    protected $listeners = ['DeselectPage' => 'updatedSelectPage', 'removeItem'];

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

    public function getAllSubjectsProperty() {
        return Subject::orderBy('code')->get(['id', 'code']);
    }

    public function removeConfirm(Subject $subject) {
        $this->subject = $subject;

        if (!$this->subject->prospectuses->isEmpty()) {
            return $this->dispatchBrowserEvent('swal:modal', [ 
                'title' => "Unable Action!",
                'type' => "error",
                'text' => "The system detected that this subject is already added in a prospectus. There maybe students enrolled under it, this
                action can produce inconsistent data.",
            ]);
        }

        $this->dispatchBrowserEvent('swal:confirmDelete', [ 
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => 'Please note that upon deletion it cannot be retrievable.',
        ]);
    }

    public function removeItem()
    {   
        $this->subject->delete();
    }

    public function viewSubject(Subject $subject)
    {
        $this->fill([
            'subject' => $subject,
            'viewingSubject' => true,
            'availableSubjects' => Subject::orderBy('code')->whereNotIn('id', [$subject->id])->get(['id', 'code']),
        ]);

        if (!$subject->requisites->isEmpty()) {
            $preRequisites = $subject->requisites->pluck('id')->toArray();
            $this->preRequisites = array_map(function($value) {
                return (string)$value;
            }, $preRequisites);
        } else {
            $this->preRequisites = [];
        }
    }

    public function updateSubject()
    {
        if (!$this->subject->requisites->isEmpty()) {
            $this->subject->requisites()->detach();
        }

        $this->save();

        $this->dispatchBrowserEvent('swal:success', [ 
            'text' => "The subject has been updated.",
        ]);

        $this->fill([ 'viewingSubject' => false ]);
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

    public function resetFields()
    {
        $this->fill([ 'subject' => new Subject() ]);
        $this->resetSubjects();
        $this->resetValidation();
    }

    public function updatedViewingSubject($value)
    {
        if (!$value) {
           $this->resetFields();
        }
    }

    public function updatedAddingSubject()
    {   
       $this->resetFields();
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
