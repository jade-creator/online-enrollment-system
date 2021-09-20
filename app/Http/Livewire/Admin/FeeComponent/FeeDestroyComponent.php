<?php

namespace App\Http\Livewire\Admin\FeeComponent;

use App\Models\Fee;
use App\Services\FeeService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class FeeDestroyComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    protected $listeners = [
        'removeFee',
        'removeConfirm',
    ];

    public function render()
    {
        return <<<'blade'
            <div>
            </div>
        blade;
    }

    public function removeConfirm(Fee $fee) {
        $this->confirm('removeFee', 'Are you sure you want this deleted?', $fee);
    }

    public function removeFee(Fee $fee)
    {
        try {
            $this->authorize('destroy', $fee);
            $fee = (new FeeService())->destroy($fee);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $fee->category->name.' has been deleted from '.$fee->program->code,
            ]);
            return redirect(route('admin.fees.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
