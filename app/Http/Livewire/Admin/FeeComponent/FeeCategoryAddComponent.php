<?php

namespace App\Http\Livewire\Admin\FeeComponent;

use App\Models\Category;
use App\Traits\WithFilters;
use App\Traits\WithSweetAlert;
use Livewire\Component;
use Livewire\WithPagination;

class FeeCategoryAddComponent extends Component
{
    use WithSweetAlert, WithFilters, WithPagination;

    public ?Category $category = NULL;
    public string $action = '';
    public bool $addingCategory = FALSE, $add = FALSE;
    public int $paginateValue = 10;

    protected $listeners = [
        'modalAddingCategory',
        'confirmDeleteCategory'
    ];

    protected $messages = [
        'category.name.required' => 'The category field cannot be empty.',
    ];

    public function rules()
    {
        return [
            'category.name' => ['required', 'string', 'max:100', 'unique:categories,name'],
        ];
    }

    public function mount() {
        $this->category = new Category();
    }

    public function render() { return
        view('livewire.admin.fee-component.fee-category-add-component', ['categories' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty() { return
        Category::select(['id', 'name'])
            ->orderBy('created_at', 'desc');
    }

    public function save()
    {
        if ($this->category->exists) {
            $this->validate([
                'category.name' => ['required', 'string', 'max:100', 'unique:categories,name,'.$this->category->id],
            ]);
        } else {
            $this->validate();
        }

        try {
            $this->category->save();

            $this->fill([
                'category' => new Category(),
                'add' => FALSE,
            ]);

            $this->emitUp('refresh');
        } catch (\Exception $e) {
            $this->emitUp('sessionFlashAlert', 'alert', 'danger', $e->getMessage());
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

    public function confirmEditCategory(?Category $category = NULL)
    {
        $this->category = $category;
        $this->add = ! $this->add;
    }

    public function confirmDeleteCategory(?Category $category = NULL) {
        $this->category = $category;
    }

    public function deleteCategory() {
        if (is_null($this->category)) return;

        try {
            $this->category->delete();

            $this->emitUp('refresh');
        } catch (\Exception $e) {
            $this->emitUp('sessionFlashAlert', 'alert', 'danger', $e->getMessage());
        }
    }
}
