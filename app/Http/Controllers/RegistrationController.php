<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class RegistrationController extends Controller
{
    public function downloadPDF() {
        $pdf = PDF::loadview('pdf.registration');
        return $pdf->download('registration.pdf');
    }
    
}
