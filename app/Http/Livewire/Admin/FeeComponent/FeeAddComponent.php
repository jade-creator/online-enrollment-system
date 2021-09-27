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
    public int $price = 0;
    public string $description = '';

    protected $listeners = [
        'createOrUpdate',
        'refresh' => '$refresh'
    ];

    public function rules()
    {
        return [
            'fee.program_id' => ['required'],
            'fee.category_id' => ['required'],
            'description' => ['nullable'],
            'price' => ['required', 'numeric', 'min:1'],
        ];
    }

    protected $messages = [
        'fee.program_id.required' => 'The program field cannot be empty.',
        'fee.category_id.required' => 'The category field cannot be empty.',
        'price.required' => 'The seat field cannot be empty.',
        'price.min' => 'The amount must be at least 1.',
    ];

    public function mount() {
        $this->fee = new Models\Fee();
    }

    public function render() { return
        view('livewire.admin.fee-component.fee-add-component');
    }

    public function createOrUpdate()
    {
        try {
            $this->authorize('create', Models\Fee::class);

            $this->fee->description = $this->description;
            $this->fee->price = $this->price;

            $fee = (new FeeService())->store($this->fee);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $fee->category->name.' has been saved to '.$fee->program->code,
            ]);
            return redirect(route('admin.fees.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function save()
    {
        $this->validate();

        $fee = (new FeeService())->find($this->fee);

        if ($fee) {
            $this->fee = $fee;
            return $this->confirm('createOrUpdate', "Program's fee already exists. Do you want to change the description and amount?");
        }

        $this->createOrUpdate();
    }

    public function getProgramsProperty() { return
        Models\Program::get(['id', 'code']);
    }

    public function getCategoriesProperty() { return
        Models\Category::get(['id', 'name']);
    }
}
