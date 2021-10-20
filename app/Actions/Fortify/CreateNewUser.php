<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        if ($input['role'] == 2) {
            Validator::make($input, ['student_id' => ['required', 'unique:students,custom_id', 'alpha_num', 'max:100']])->validate();
        } else {
            Validator::make($input, ['employee_id' => ['required', 'unique:employees,custom_id', 'alpha_num', 'max:100']])->validate();
        }

        Validator::make($input, [
            'role' => ['required'],
            'name' => ['required', 'string', 'min:6', 'max:30', 'alpha_dash', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role_id' => $input['role'],
        ]);
    }
}
