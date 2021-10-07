<?php

namespace App\Exports;

use App\Models\Faculty;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FacultiesExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    protected $faculties;

    public function __construct($faculties)
    {
        $this->faculties = $faculties;
    }

    public function query()
    {
        return Faculty::query()->whereKey($this->faculties);
    }

    public function headings(): array
    {
        return [
            'Faculty Name',
            'Program',
            'Description',
            'Mission',
            'Vision',
        ];
    }

    public function map($faculty): array
    {
        return [
            $faculty->name ?? 'N/A',
            $faculty->program->code ?? 'N/A',
            $faculty->description ?? 'N/A',
            $faculty->mission ?? 'N/A',
            $faculty->vision ?? 'N/A',
        ];
    }
}
