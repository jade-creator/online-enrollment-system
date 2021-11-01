<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function downloadRegistration() {
        $pdf = PDF::loadview('pdf.registration');
        return $pdf->stream('registration.pdf');
    }

    public function downloadGrade() {
        $pdf = PDF::loadview('pdf.grade');
        return $pdf->stream('grade.pdf');
    }

    public function downloadClassList() {
        $pdf = PDF::loadview('pdf.classlist');
        return $pdf->stream('classlist.pdf');
    }

}
