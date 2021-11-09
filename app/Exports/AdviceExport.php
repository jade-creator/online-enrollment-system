<?php

namespace App\Exports;

use App\Models\Advice;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdviceExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    protected $advices;

    public function __construct($advices)
    {
        $this->advices = $advices;
    }

    public function query()
    {
        return Advice::query()->whereKey($this->advices);
    }

    public function headings(): array
    {
        return [
            'program/s',
            'level/s',
            'date',
            'time',
            'link',
            'remarks',
        ];
    }

    public function map($advice): array
    {
        return [
            $advice->program->code ?? 'All Programs',
            $advice->level->level ?? 'All Levels',
            $advice->date ?? 'N/A',
            $advice->time ?? 'N/A',
            $advice->link ?? 'N/A',
            $advice->remarks ?? 'N/A',
        ];
    }
}
