<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function query()
    {
        return Student::query()->whereKey($this->students);
    }

    public function headings(): array
    {
        return [
            'student ID',
            'Name',
            'Email',
            'Grand Total',
            'Balance',
        ];
    }

    public function map($student): array
    {
        return [
            $student->custom_id ?? 'N/A',
            $student->user->person->full_name ?? 'N/A',
            $student->user->email ?? 'N/A',
            $student->getFormattedPriceAttribute($student->grandTotal->sum('grand_total')) ?? 'N/A',
            $student->getFormattedPriceAttribute($student->grandTotal->sum('balance')) ?? 'N/A',
        ];
    }
}
