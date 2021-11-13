<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Registration;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Schedule\CalendarService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    use AuthorizesRequests;

    public function downloadPDF($pdflocation, $pdfname) {
        $pdf = PDF::loadview($pdflocation);
        return $pdf->stream($pdfname);
    }

    public function stream(string $templateLocation, array $array = [], string $fileName = 'Print PDF')
    {
        $pdf = PDF::loadView($templateLocation, $array);
        return $pdf->stream($fileName);
    }

    public function streamTransaction(Transaction $transaction)
    {
        return $this->stream('pdf.transaction', [
            'transaction' => $transaction,
        ], $transaction->custom_id.'.pdf');
    }

    public function streamDashboard()
    {
        $this->authorize('export', \App\Models\Registration::class);

        $programs = Program::get(['id', 'code']);

        $programIds = $programs->pluck('id')->toArray();

        $students = Student::all();
        $programsData = [];
        $counter = 0;

        foreach ($programIds as $index => $id) {

            $programCode = $programs->first(function ($program) use ($id) {
                return $program->id == $id;
            })->code ?? 'N/A';

            //check if divisible by four.
            if ($index % 4 == 0) $counter++;

            $programsData[$counter][$programCode] = $students->filter( function ($student) use ($id) {
                return $student->program_id == $id;
            })->count();
        }

        $registrationCollection = Registration::get();

        $userCollection = User::with(['role', 'person.detail'])->get();

        return $this->stream('pdf.dashboard-overview', [
            'users' => $userCollection->count(),
            'registrations' => $registrationCollection->count(),
            'sections' => Section::get('id')->count(),
            'subjects' => Subject::get('id')->count(),
            'female' => $userCollection->filter(function ($user) {
                $gender = $user->person->detail->gender ?? 'N/A';
                return $gender == 'Female';
            })->count(),
            'male' => $userCollection->filter(function ($user) {
                $gender = $user->person->detail->gender ?? 'N/A';
                return $gender == 'Male';
            })->count(),
            'other' => $userCollection->filter(function ($user) {
                $gender = $user->person->detail->gender ?? 'N/A';
                return $gender == 'Other';
            })->count(),
            'prefer' => $userCollection->filter(function ($user) {
                $gender = $user->person->detail->gender ?? 'N/A';
                return $gender == 'Prefer not to say';
            })->count(),
            'admin' => $userCollection->filter(function ($user) {
                $role = $user->role->name ?? 'N/A';
                return $role == 'admin';
            })->count(),
            'student' => $userCollection->filter(function ($user) {
                $role = $user->role->name ?? 'N/A';
                return $role == 'student';
            })->count(),
            'registrar' => $userCollection->filter(function ($user) {
                $role = $user->role->name ?? 'N/A';
                return $role == 'registrar';
            })->count(),
            'dean' => $userCollection->filter(function ($user) {
                $role = $user->role->name ?? 'N/A';
                return $role == 'dean';
            })->count(),
            'faculty' => $userCollection->filter(function ($user) {
                $role = $user->role->name ?? 'N/A';
                return $role == 'faculty member';
            })->count(),
            'enrolled' => $registrationCollection->filter(function ($registration) {
                $status = $registration->status_id ?? 'N/A';
                return $status == 4;
            })->count(),
            'finalized' => $registrationCollection->filter(function ($registration) {
                $status = $registration->status_id ?? 'N/A';
                return $status == 3;
            })->count(),
            'confirming' => $registrationCollection->filter(function ($registration) {
                $status = $registration->status_id ?? 'N/A';
                return $status == 2;
            })->count(),
            'pending' => $registrationCollection->filter(function ($registration) {
                $status = $registration->status_id ?? 'N/A';
                return $status == 1;
            })->count(),
            'programsData' => $programsData,
        ], 'dashboard-overview.pdf');
    }

    public function streamMasterlist()
    {
        $this->authorize('masterlist', Faculty::class);

        $masterlist = Faculty::with([
            'programs.prospectuses.registrations' => function ($query) {
                $result = $query->whereBetween('created_at', [
                    now()->startOfYear(),
                    now()->endOfYear(),
                ])->where('status_id', '!=', 1)->get();

                return $result->groupBy('section_id');
            },
            'programs.prospectuses.registrations.student.user.person'
        ])
        ->get();

        return $this->stream('pdf.masterlist', [
            'masterlist' => $masterlist
        ], Carbon::parse(now())->format('Y').'-'.Carbon::parse(now())->addYear()->format('Y').'.pdf');
    }

    public function streamSchedule(Section $section)
    {
        $weekDays = Day::get(['id', 'name']);
        $calendarData = (new CalendarService())->generateCalendarData($section, $weekDays);

        return $this->stream('pdf.schedule', [
            'section' => $section,
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
        $schedules = $registration->classes;

        if ($registration->extensions->isNotEmpty()) {
            foreach ($registration->extensions as $extension) {
                $schedules = $schedules->merge($extension->registration->classes);
            }
        }

        $schedules = $schedules
            ->sort(function($class) {
                return [$class->start_time, $class->day_id];
            })
            ->groupBy(['prospectus_subject_id', 'section_id', 'start_time', 'end_time', 'employee_id']);

        return $this->stream('pdf.registration', [
            'registration' => $registration,
            'totalUnit' => request()->query('totalUnit') ?? 0,
            'prospectus_subjects' => $schedules
        ], $registration->student->user->person->full_name.'-registration.pdf');
    }
}
