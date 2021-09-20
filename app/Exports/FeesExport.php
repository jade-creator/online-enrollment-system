<?php

namespace App\Exports;

use App\Models\Fee;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FeesExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    protected $fees;

    public function __construct($fees)
    {
        $this->fees = $fees;
    }

    public function query()
    {
        return Fee::query()->whereKey($this->fees);
    }

    public function headings(): array
    {
        return [
            'Fee Id',
            'Category',
            'Program',
            'Description',
            'Amount',
            'Added at',
        ];
    }

    public function map($fee): array
    {
        return [
            $fee->id ?? 'N/A',
            $fee->category->name ?? 'N/A',
            $fee->program->code ?? 'N/A',
            $fee->description ?? 'N/A',
            $fee->price ?? 'N/A',
            $fee->created_at ?? 'N/A',
        ];
    }
}
