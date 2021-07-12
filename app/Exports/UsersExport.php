<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function query()
    {
        return User::query()->whereKey($this->users);
    }

    public function headings(): array
    {
        return [
            'name',
            'email',
            'role',
        ];
    }

    public function map($user): array
    {
        return [
            $user->name ?? 'N/A',
            $user->email ?? 'N/A',
            $user->role->name ?? 'N/A',
        ];
    }
}

