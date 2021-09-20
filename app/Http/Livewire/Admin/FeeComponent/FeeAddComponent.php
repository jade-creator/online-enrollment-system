<?php

namespace App\Http\Livewire\Admin\FeeComponent;

use App\Models;
use App\Services\FeeService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class FeeAddComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Fee $fee;

    public function rules()
    {
        return [
            'fee.program_id' => ['required'],
            'fee.category_id' => ['required'],
            'fee.description' => ['nullable'],
            'fee.price' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function mount() {
        $this->fee = new Models\Fee();
    }

    public function render() { return
        view('livewire.admin.fee-component.fee-add-component');
    }

    public function save()
    {
        $this->validate();

        try {
            $this->authorize('create', Models\Fee::class);
            $fee = (new FeeService())->store($this->fee);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $fee->category->name.' has been added to '.$fee->program->code,
            ]);
            return redirect(route('admin.fees.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function getProgramsProperty() { return
        Models\Program::get(['id', 'code']);
    }

    public function getCategoriesProperty() { return
        Models\Category::get(['id', 'name']);
    }
}
