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
            'Registration Id',
            'Student Id',
            'Full Name',
            'Status',
            'Program',
            'Level',
            'Term',
            'Section',
        ];
    }

    public function map($registration): array
    {
        return [
            $registration->id ?? 'N/A',
            $registration->student->custom_id ?? 'N/A',
            $registration->student->user->person->full_name ?? 'N/A',
            $registration->status->name ?? 'N/A',
            $registration->prospectus->program->code ?? 'N/A',
            $registration->prospectus->level->level ?? 'N/A',
            $registration->prospectus->term->term ?? 'N/A',
            $registration->section->name ?? 'N/A',
        ];
    }
}
