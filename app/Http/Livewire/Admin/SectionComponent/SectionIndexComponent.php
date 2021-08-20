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

    public int $paginateValue = 10, $currentNumberOfStudents = 0;
    public string $prospectusId = '';
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

    protected $listeners = [
        'DeselectPage' => 'updatedSelectPage',
        'refresh' => '$refresh',
        'setProspectusId',
        'releaseStudents',
        'removeConfirm',
    ];

    protected array $allowedSorts = [
        'id',
        'name',
    ];

    public function mount() { $this->fill([ 'registrations' => collect() ]); }

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

    public function setProspectusId($value)
    {
        $this->prospectusId = $value;
        $this->resetPage();
    }

    public function removeConfirm(Models\Section $section)
    {
        if (!$section->registrations->isEmpty()) {
            return $this->dispatchBrowserEvent('swal:modal', [
                'title' => "Warning!",
                'type' => "warning",
                'text' => "There are students enrolled under ".$section->name,
            ]);
        }

        $this->dispatchBrowserEvent('swal:confirmDelete', [
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => 'Deleting '.$section->name.' cannot be retrievable.',
            'item' => $section,
        ]);
    }

    public function getRoomsProperty() { return
        Models\Room::select(['id', 'name'])
            ->get();
    }

    public function fileExport() { return
        $this->excelFileExport((new SectionsExport($this->selected)), 'section-collection.xlsx');
    }
}
