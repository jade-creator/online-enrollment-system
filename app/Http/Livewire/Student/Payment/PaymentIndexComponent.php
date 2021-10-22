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
    public string $isArchived = '0';

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
        'isArchived' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'search',
        'isArchived'
    ];

    protected array $allowedSorts = [
        'id',
        'amount',
    ];

    protected $listeners = [
        'DeselectPage' => 'updatedSelectPage',
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
            ->with([
                'registration.assessment',
                'registration.prospectus.level',
                'registration.prospectus.term',
            ])
            ->filterByStudent(auth()->user()->student->id)
            ->when(filled($this->search), function ($query) {
                $query->orWhereHas('registration', function ($query) {
                    $query->where('custom_id', $this->search);
                });
            })
            ->when($this->isArchived == '1', function ($query) {
                $query->whereNotNull('archived_at');
            })
            ->when($this->isArchived == '0', function ($query) {
                $query->whereNull('archived_at');
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

    public function unarchive(Models\Transaction $transaction)
    {
        try {
            $transaction->archived_at = NULL;
            return $transaction->update();
        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $e->getMessage(),
            ]);

            return $this->emit('alert');
        }
    }

    public function archive(Models\Transaction $transaction)
    {
        try {
            $transaction->archived_at = now();
            $transaction->update();
        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $e->getMessage(),
            ]);

            return $this->emit('alert');
        }
    }

    public function unarchiveAll()
    {
        try {
            Models\Transaction::whereIn('id', $this->selected)->update(['archived_at' => NULL]);
            $this->emitSelf('DeselectPage', FALSE);
        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $e->getMessage(),
            ]);

            return $this->emit('alert');
        }
    }

    public function archiveAll()
    {
        try {
            Models\Transaction::whereIn('id', $this->selected)->update(['archived_at' => now()]);
            $this->emitSelf('DeselectPage', FALSE);
        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $e->getMessage(),
            ]);

            return $this->emit('alert');
        }
    }
}
