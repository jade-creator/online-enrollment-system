<?php

namespace App\Http\Livewire\Admin\UserComponent;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models;
use App\Rules\GmailId;
use App\Services\UserService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class UserAddComponent extends Component
{
    use AuthorizesRequests, PasswordValidationRules, WithSweetAlert;

    public bool $addingUser = false;
    public string $role_id = '', $name = '', $email = '', $password = '', $password_confirmation = '';
    public $roles;

    protected $listeners = ['modalAddingUser'];

    public function rules()
    {
        return [
            'role_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', new GmailId],
            'password' => $this->passwordRules(),
        ];
    }

    public function render() { return
        view('livewire.admin.user-component.user-add-component');
    }

    public function modalAddingUser()
    {
        $this->resetValidation();
        $this->reset(['role_id', 'name', 'email', 'password', 'password_confirmation']);
        $this->toggleModal();
    }

    public function save()
    {
        $this->authorize('create', Models\User::class);
        $this->validate();

        try {
            (new UserService())->store($this->role_id, $this->name, $this->email, $this->password);

            $this->toggleModal();
            $this->emitUp('refresh');
            $this->success($this->name.' has been added.');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function toggleModal() : bool { return
        $this->addingUser = ! $this->addingUser;
    }
}
