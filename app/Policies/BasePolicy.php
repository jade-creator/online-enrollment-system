<?php

namespace App\Policies;

use App\Models\User;

class BasePolicy
{
    protected $authorizedActions = [
        'section' => [
            'createClass' => ['admin', 'dean'],
            'create' => ['admin', 'dean'],
            'update' => ['admin', 'dean'],
            'destroy' => ['admin', 'dean'],
            'release' => ['admin', 'dean'],
            'printClasslist' => ['admin', 'dean', 'registrar', 'faculty member'],
        ],
        'schedule' => [
            'update' => ['admin', 'registrar'],
            'destroy' => ['admin', 'registrar'],
        ],
        'assessment' => [
            'view' => ['admin', 'registrar', 'dean'],
            'create' => ['admin', 'registrar', 'dean'],
        ],
        'registration' => [
            'edit' => ['admin', 'registrar'],
            'enroll' => ['admin', 'registrar'],
            'reject' => ['admin', 'registrar'],
            'confirm' => ['admin', 'registrar', 'dean'],
            'pending' => ['admin', 'registrar', 'dean'],
            'finalize' => ['admin', 'registrar', 'dean'],
            'update' => ['admin', 'registrar'],
            'selectSection' => ['admin', 'registrar', 'student', 'dean'],
            'exportRegistration' => ['admin', 'registrar', 'student'],
            'create' => ['admin', 'registrar', 'student'],
            'archive' => ['admin', 'registrar'],
            'unarchive' => ['admin', 'registrar'],
        ],
        'grade' => [
            'update' => ['admin', 'dean', 'faculty member'],
            'export' => ['admin', 'registrar'],
        ],
        'person' => [
            'view' => ['admin', 'registrar', 'dean', 'faculty member'],
        ],
        'prospectus' => [
            'register' => ['admin', 'student', 'registrar'],
        ],
        'transaction' => [
            'view' => ['admin', 'registrar', 'dean'],
            'export' => ['admin', 'student'],
            'create' => ['student'],
            'cash' => ['admin', 'registrar', 'dean', 'faculty'],
        ],
        'faculty' => [
            'masterlist' => ['admin', 'registrar']
        ],
        'user' => [
            'enroll' => ['admin', 'registrar']
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
