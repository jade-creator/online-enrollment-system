<?php

namespace App\Http\Livewire\Forms\User;

use App\Models\Role;
use App\Models\User;
use App\Rules\GmailId;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\PasswordValidationRules;

class UserForm extends Component
{
    use PasswordValidationRules;

    public $role;
    public $name;
    public $email;
    public $password;   
    public $password_confirmation;   

    public function rules()
    {
        return [
            'role' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', new GmailId],
            'password' => $this->passwordRules(),  
        ];
    }

    public function render()
    {
        return view('livewire.forms.user.user-form', [
            'roles' => Role::get([ 'id', 'name'])
        ]);
    }

    public function create()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role_id' => $this->role,
        ]);

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'User Saved',
            'data' => $this->name,
            'message' => ' has been saved.',
        ]);

        return redirect()->to('admin/users');
    }
}

