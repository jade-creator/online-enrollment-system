<?php

namespace App\Exports;

use App\Models\Strand;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StrandsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    protected $strands;
    
    public function __construct($strands)
    {
        $this->strands = $strands;
    }

    public function query()
    {
        return Strand::query()->whereKey($this->strands);
    }

    public function headings(): array
    {
        return [
            'Code',
            'Strand',
        ];
    }

    public function map($strand): array
    {
        return [
            $strand->code ?? 'N/A',
            $strand->strand ?? 'N/A',
        ];
    }
}
