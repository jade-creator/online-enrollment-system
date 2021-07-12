<?php

namespace App\Exports;

use App\Models\Track;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TracksExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    protected $tracks;
    
    public function __construct($tracks)
    {
        $this->tracks = $tracks;
    }

    public function query()
    {
        return Track::query()->whereKey($this->tracks);
    }

    public function headings(): array
    {
        return [
            'Track',
            'Description',
        ];
    }

    public function map($track): array
    {
        return [
            $track->track ?? 'N/A',
            $track->description ?? 'N/A',
        ];
    }
}
