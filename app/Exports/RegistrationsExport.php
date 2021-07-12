<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RegistrationsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    protected $registrations;
    
    public function __construct($registrations)
    {
        $this->registrations = $registrations;
    }

    public function query()
    {
        return Registration::query()->whereKey($this->registrations);
    }

    public function headings(): array
    {
        return [
            'Student Id',
            'Name',
            'Level',
            'Section',
            'Status',
        ];
    }

    public function map($registration): array
    {
        return [
            $registration->student->custom_student_id ?? '--',
            $registration->student->user->person->full_name ?? 'N/A',
            $registration->prospectus->level->level ?? 'N/A',
            $registration->section->name ?? '--',
            $registration->status->name ?? 'N/A',
        ];
    }
}
