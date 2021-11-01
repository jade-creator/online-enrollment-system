<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function downloadPDF($pdflocation, $pdfname) {
        $pdf = PDF::loadview($pdflocation);
        return $pdf->stream($pdfname);
    }
}
