<?php

namespace App\Exports;

use App\Models\Curriculum;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CurriculaExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    public $curricula;

    public function __construct($curricula)
    {
        $this->curricula = $curricula;
    }

    public function query()
    {
        return Curriculum::query()->whereKey($this->curricula);
    }

    public function headings(): array
    {
        return [
            'Code',
            'Program',
            'Description',
            'State',
            'School Year'
        ];
    }

    public function map($curriculum): array
    {
        return [
            $curriculum->code ?? 'N/A',
            $curriculum->program->name ?? 'N/A',
            $curriculum->description ?? 'N/A',
            $curriculum->state ?? 'N/A',
            $curriculum->school_year ?? 'N/A',
        ];
    }
}
