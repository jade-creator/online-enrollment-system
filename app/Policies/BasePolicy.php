<?php

namespace App\Policies;

use App\Models\User;

class BasePolicy
{
    protected $authorizedActions = [
        'section' => [
            'createClass' => ['admin', 'registrar'],
        ],
        'schedule' => [
            'update' => ['admin', 'registrar'],
            'destroy' => ['admin', 'registrar'],
        ],
        'assessment' => [
            'view' => ['admin', 'registrar'],
            'create' => ['admin', 'registrar'],
        ],
        'registration' => [
            'edit' => ['admin', 'registrar'],
            'enroll' => ['admin', 'registrar'],
            'reject' => ['admin', 'registrar'],
            'confirm' => ['admin', 'registrar'],
            'pending' => ['admin', 'registrar'],
            'update' => ['admin', 'registrar'],
            'selectSection' => ['admin', 'registrar', 'student'],
            'exportRegistration' => ['admin', 'registrar'],
        ],
        'grade' => [
            'update' => ['admin', 'registrar'],
        ],
        'person' => [
            'view' => ['admin', 'registrar', 'dean', 'faculty member'],
        ],
        'prospectus' => [
            'register' => ['admin', 'student', 'registrar'],
        ]
    ];

    public function isAuthorized(string $policy, string $action, User $user) : bool
    {
        return is_array($this->authorizedActions) && array_key_exists($policy, $this->authorizedActions) &&
            array_key_exists($action, $this->authorizedActions[$policy]) && in_array($user->role->name, $this->authorizedActions[$policy][$action]);
    }

    public function isAdmin(User $user) { return
        $user->role->name == 'admin';
    }
}
