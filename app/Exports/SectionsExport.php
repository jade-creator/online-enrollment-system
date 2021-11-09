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
            'Program',
            'Level',
            'Semester',
            'Room',
            'No. of Seats',
            'Slots'
        ];
    }

    public function map($section): array
    {
        return [
            $section->id ?? 'N/A',
            $section->name ?? 'N/A',
            $section->prospectus->program->program ?? 'N/A',
            $section->prospectus->level->level ?? 'N/A',
            $section->prospectus->term->term ?? 'N/A',
            $section->room->name ?? 'N/A',
            $section->seat ?? 'N/A',
            $section->registrations->count() ?? 'N/A',
        ];
    }
}
