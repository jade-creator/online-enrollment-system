<?php

namespace App\Http\Livewire\Student\Payment;

use App\Models;
use App\Traits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire;

class PaymentIndexComponent extends Livewire\Component
{
    use AuthorizesRequests;
    use Livewire\WithPagination, Traits\WithBulkActions, Traits\WithSorting, Traits\WithFilters, Traits\WithExporting,
        Traits\WithSweetAlert;

    public int $paginateValue = 10;

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
    ];

    protected $updatesQueryString = [ 'search' ];

    protected array $allowedSorts = [
        'id',
        'amount',
    ];

    protected $listeners = [
        'refresh' => '$refresh',
        'fileExport',
    ];

    public function render() { return
        view('livewire.student.payment.payment-index-component', ['transactions' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return Models\Transaction::search($this->search)
            ->filterByStudent(auth()->user()->student->id)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->dateFiltered($this->dateMin, $this->dateMax);
    }
}
