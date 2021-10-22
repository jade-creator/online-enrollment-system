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
            ->when(filled($this->search), function ($query) {
                return $query->orWhereHas('registration', function ($query) {
                    return $query->where('custom_id', $this->search);
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->dateFiltered($this->dateMin, $this->dateMax);
    }


    public function pay()
    {
        if (auth()->user()->student->registrations->isEmpty()) {
            session()->flash('alert', [
                'type' => 'info',
                'message' => 'You are not registered. Click <a href="'.route('student.registrations.create').'" class="underline">register</a> now',
            ]);
        }

        if (auth()->user()->student->registrations->isNotEmpty()
                && auth()->user()->student->grandTotal->sum('balance') == 0) {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'No balance found. You are fully paid as of '.date('M d Y'),
            ]);

            return $this->emit('alert');
        }

        $registration = Models\Registration::with('assessment')
            ->where('student_id', auth()->user()->student->id)
            ->whereHas('assessment', function ($query) {
                return $query->where('balance', '!=', 0);
            })
            ->first();

        return $this->redirect(route('student.paywithpaypal', $registration->custom_id));
    }
}
