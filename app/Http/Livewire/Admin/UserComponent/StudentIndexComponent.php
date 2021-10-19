<?php

namespace App\Http\Livewire\Admin\UserComponent;

use App\Models;
use App\Traits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire;

class StudentIndexComponent extends Livewire\Component
{
    use AuthorizesRequests;
    use Livewire\WithPagination, Traits\WithBulkActions, Traits\WithSorting, Traits\WithFilters, Traits\WithExporting,
        Traits\WithSweetAlert;

    public Models\Student $student;
    public int $paginateValue = 10;
//    public string $isRegular = '', $isNew = ''; TODO

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
    ];

    protected $updatesQueryString = ['search'];

    protected $listeners = [
        'DeselectPage' => 'updatedSelectPage',
        'refresh' => '$refresh',
//        'fileExport', TODO
    ];

    protected array $allowedSorts = ['custom_id'];

    public function render() { return
        view('livewire.admin.user-component.student-index-component', ['students' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return Models\Student::search($this->search)
            ->with('user')
            ->when(filled($this->search), function ($query) {
                return $query->orWhereHas('user', function ($query) {
                    return $query->where('name', $this->search)
                        ->orWhere('email', $this->search);
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->dateFiltered($this->dateMin, $this->dateMax);
    }
}
