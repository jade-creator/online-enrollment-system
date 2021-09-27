<?php

namespace App\Traits;

trait WithExporting
{
    public bool $confirmingExport = false;

    public function confirmFileExport() { return
        $this->confirm('fileExport', 'Are you sure? Please confirm to export selected data.');
    }

    public function excelFileExport($export, $excelFileName)
    {
        $this->confirmingExport = false;
        return $export->download($excelFileName);
    }
}
