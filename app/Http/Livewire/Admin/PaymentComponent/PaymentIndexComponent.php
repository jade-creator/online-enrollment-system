<?php

namespace App\Http\Livewire\Admin\PaymentComponent;

use App\Exports\TransactionsExport;
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

    public function mount() {
        $this->authorize('view', Models\Transaction::class);
    }

    public function render() { return
        view('livewire.admin.payment-component.payment-index-component', ['transactions' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return Models\Transaction::search($this->search)
            ->with([
                'registration.student.user.person',
                'registration.assessment',
                'registration.prospectus' => function ($query) {
                    $query->with(['program', 'level', 'term']);
                },
            ])
            ->when(filled($this->search), function ($query) {
                return $query->orWhereHas('registration', function ($query) {
                    return $query->where('custom_id', $this->search);
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->dateFiltered($this->dateMin, $this->dateMax);
    }

    public function fileExport()
    {
        try {
            return $this->excelFileExport((new TransactionsExport($this->selected)), 'transaction-collection.xlsx');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
