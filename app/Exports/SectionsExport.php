<?php

namespace App\Exports;

use App\Models\Section;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SectionsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    protected $sections;
    
    public function __construct($sections)
    {
        $this->sections = $sections;
    }

    public function query()
    {
        return Section::query()->whereKey($this->sections);
    }

    public function headings(): array
    {
        return [
            'Section ID',
            'Name',
            'Remarks',
            'Room',
        ];
    }

    public function map($section): array
    {
        return [
            $section->id ?? 'N/A',
            $section->name ?? 'N/A',
            $section->remarks ?? 'N/A',
            $section->room->name ?? 'N/A',
        ];
    }
}
