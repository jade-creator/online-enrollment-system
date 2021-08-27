<?php

namespace App\Exports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubjectsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    protected $subjects;

    public function __construct($subjects)
    {
        $this->subjects = $subjects;
    }

    public function query()
    {
        return Subject::query()->whereKey($this->subjects);
    }

    public function headings(): array
    {
        return [
            'Code',
            'Title',
            'Description',
        ];
    }

    public function map($subject): array
    {
        return [
            $subject->code ?? 'N/A',
            $subject->title ?? 'N/A',
            $subject->description ?? 'N/A',
        ];
    }
}
