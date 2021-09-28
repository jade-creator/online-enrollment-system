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

    public string $role_id = '1', $name = '', $email = '', $password = '', $password_confirmation = '';
    public string $employee_id = '', $student_id = '';

    public function rules()
    {
        return [
            'role_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', new GmailId],
            'password' => $this->passwordRules(),
            'employee_id' => ['required_if:role_id,==,1,3,4,5'],
            'student_id' => ['required_if:role_id,==,2'],
        ];
    }

    protected $messages = [
        'role_id' => 'The role field cannot be empty.',
        'employee_id.required_if' => 'The employee id field cannot be empty.',
        'student_id.required_if' => 'The student id field cannot be empty.',
    ];

    public function render() { return
        view('livewire.admin.user-component.user-add-component');
    }

    public function save()
    {
        $this->validate();

        try {
            $this->authorize('create', Models\User::class);
            $user = (new UserService())->store($this->role_id, $this->student_id, $this->employee_id, $this->name, $this->email, $this->password);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $user->name.' has been added.',
            ]);
            return redirect(route('admin.users.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function getRolesProperty() { return
        Models\Role::get(['id', 'name']);
    }
}
