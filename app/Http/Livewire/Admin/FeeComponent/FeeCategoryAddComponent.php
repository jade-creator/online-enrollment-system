<?php

namespace App\Http\Livewire\Admin\FeeComponent;

use App\Models\Category;
use App\Traits\WithSweetAlert;
use Livewire\Component;

class FeeCategoryAddComponent extends Component
{
    use WithSweetAlert;

    public Category $category;
    public string $action = '';
    public bool $addingCategory = false;

    protected $listeners = ['modalAddingCategory'];

    public function rules()
    {
        return [
            'category.name' => ['required', 'string', 'max:100'],
        ];
    }

    public function render() { return
        view('livewire.admin.fee-component.fee-category-add-component');
    }

    public function save()
    {
        $this->validate();

        try {
            $this->category->save();

            $this->success($this->category->name.' has been added.');
            $this->toggleModal();
            $this->emitUp('refresh');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function modalAddingCategory()
    {
        $this->resetValidation();
        $this->category = new Category();
        $this->toggleModal();
    }

    public function toggleModal() {
        $this->addingCategory = !$this->addingCategory;
    }
}
