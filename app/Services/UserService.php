<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function store(string $role_id, string $student_id, string $employee_id, string $name, string $email, string $password) : User
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role_id' => $role_id,
        ]);

        if (filled($student_id)) {
            $user->student()->create([
                'custom_id' => $student_id,
            ]);
        } else {
            $user->employee()->create([
                'custom_id' => $employee_id,
            ]);
        }

        return $user;
    }

    public function update(string $student_id, string $employee_id, User $user) : User
    {
        $user->update();

        if (filled($student_id)) {
            $user->student()->create([
                'custom_id' => $student_id,
            ]);
        } else {
            $user->employee()->create([
                'custom_id' => $employee_id,
            ]);
        }

        return $user;
    }
}
