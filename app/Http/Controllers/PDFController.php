<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Registration;
use App\Models\Section;
use App\Services\Schedule\CalendarService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    use AuthorizesRequests;

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

    public function streamSchedule(Section $section)
    {
        $weekDays = Day::get(['id', 'name']);
        $calendarData = (new CalendarService())->generateCalendarData($section, $weekDays);

        return $this->stream('pdf.schedule', [
            'calendarData' => $calendarData,
            'weekDays' => $weekDays
        ], $section->name.'-schedule.pdf');
    }

    public function streamClasslist(Section $section)
    {
        $this->authorize('printClaslist', $section);

        $registrations = $section->registrations()->with('student.user.person')->whereNull('released_at')->get();

        return $this->stream('pdf.classlist', [
            'section' => $section,
            'registrations' => $registrations
        ], $section->name.'-'.$section->prospectus->term->term.'-classlist.pdf');
    }

    public function streamGrade(Registration $registration)
    {
        request()->query('professors') && filled(request()->query('professors')) ? parse_str(request()->query('professors'), $professors) : $professors = [];
        request()->query('grades') && filled(request()->query('grades')) ? parse_str(request()->query('grades'), $grades) : $grades = [];
        request()->query('notComputed') && filled(request()->query('notComputed')) ? parse_str(request()->query('notComputed'), $notComputed) : $notComputed = [];

        return $this->stream('pdf.grade', [
            'registration' => $registration,
            'professors' => $professors['professors'],
            'computedGrade' => request()->query('computedGrade') ?? 0,
            'grades' => $grades['grades'] ?? [],
            'notComputed' => $notComputed['notComputed'] ?? []
        ], $registration->student->user->person->full_name.'-grade.pdf');
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
    }
}
