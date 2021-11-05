<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public $totalUnit = 0;

    public function downloadPDF($pdflocation, $pdfname) {
        $pdf = PDF::loadview($pdflocation);
        return $pdf->stream($pdfname);
    }

    public function stream(string $templateLocation, array $array = [], string $fileName = 'Print PDF')
    {
        $pdf = PDF::loadView($templateLocation, $array);
        return $pdf->stream($fileName);
    }

    public function streamRegistration(Registration $registration)
    {
        $schedules = $registration->classes()
            ->orderBy('day_id', 'desc')
            ->orderBy('start_time', 'desc')
            ->get()
            ->groupBy(['prospectus_subject_id', 'section_id', 'start_time', 'end_time', 'employee_id']);

        return $this->stream('pdf.registration', [
            'registration' => $registration,
            'totalUnit' => request()->query('totalUnit') ?? 0,
            'prospectus_subjects' => $schedules
        ], $registration->student->user->person->full_name.'-registration.pdf');

//        $pdf = PDF::loadView('pdf.registration', [
//            'registration' => $registration,
//            'totalUnit' => request()->query('totalUnit') ?? 0,
//            'prospectus_subjects' => $schedules
//        ]);
//        return $pdf->stream('registration.pdf');
    }
}
