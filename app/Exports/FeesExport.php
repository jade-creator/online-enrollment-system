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
            'Name',
            'Price',
        ];
    }

    public function map($fee): array
    {
        return [
            $fee->id ?? 'N/A',
            $fee->name ?? 'N/A',
            $fee->price ?? 'N/A',
        ];
    }
}
