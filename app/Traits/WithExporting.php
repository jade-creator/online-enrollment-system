<?php

namespace App\Traits;

trait WithExporting
{
    public bool $confirmingExport = false;

    public function excelFileExport($export, $excelFileName)
    {
        $this->confirmingExport = false;
        return $export->download($excelFileName);
    }
}
