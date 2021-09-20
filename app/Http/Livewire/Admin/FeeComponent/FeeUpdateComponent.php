<?php

namespace App\Http\Livewire\Admin\FeeComponent;

use App\Models;
use App\Services\FeeService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class FeeUpdateComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Fee $fee;

    protected $listeners = ['refresh' => '$refresh'];

    public function rules()
    {
        return [
            'fee.program_id' => ['required'],
            'fee.category_id' => ['required'],
            'fee.description' => ['nullable'],
            'fee.price' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function render() { return
        view('livewire.admin.fee-component.fee-update-component', [
            'programs' => $this->getPrograms(),
            'categories' => $this->getCategories(),
        ]);
    }

    public function update()
    {
        $this->validate();

        try {
            $this->authorize('update', $this->fee);
            $fee = (new FeeService())->update($this->fee);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $fee->category->name.' has been updated.',
            ]);
            return redirect(route('admin.fees.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function getPrograms() { return
        Models\Program::get(['id', 'code']);
    }

    public function getCategories() { return
        Models\Category::get(['id', 'name']);
    }
}
