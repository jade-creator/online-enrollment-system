<?php

namespace App\Exports;

use App\Models\Program;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProgramsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    protected $programs;

    public function __construct($programs)
    {
        $this->programs = $programs;
    }

    public function query()
    {
        return Program::query()->whereKey($this->programs);
    }

    public function headings(): array
    {
        return [
            'Code',
            'Program',
            'Description',
            'Number of Years',
        ];
    }

    public function map($program): array
    {
        return [
            $program->code ?? 'N/A',
            $program->program ?? 'N/A',
            $program->description ?? 'N/A',
            $program->year ?? 'N/A',
        ];
    }
}
