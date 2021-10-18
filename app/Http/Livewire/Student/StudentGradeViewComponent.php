<?php

namespace App\Http\Livewire\Student;

use App\Models;
use Livewire\Component;

class StudentGradeViewComponent extends Component
{
    public Models\Prospectus $prospectus;
    public ?Models\Registration $registration = null;
    public ?Models\Level $level = null;
    public ?Models\Term $semester = null;
    public string $levelId = '', $semesterId = '';
    public array $grades = [];

    protected $queryString = [
        'levelId' => [ 'except' => '' ],
        'semesterId' => [ 'except' => '' ]
    ];

    protected $updatesQueryString = [
        'levelId',
        'semesterId'
    ];

    public function mount()
    {
        $this->level = Models\Level::where('id', filled($this->levelId) ? $this->levelId : '14')->first();
        $this->semester = Models\Term::where('id', filled($this->semesterId) ? $this->semesterId : '1')->first();

        $this->fill([
            'levelId' => $this->level->id ?? '',
            'semesterId' => $this->semester->id ?? '',
        ]);

        $this->prospectus = Models\Prospectus::select(['id', 'level_id', 'program_id', 'term_id'])
            ->with([
                'subjects' => function($query) {
                    return $query->where('curriculum_id', auth()->user()->student->curriculum_id)->get();
                },
                'subjects.subject',
                'subjects.corequisites',
                'subjects.prerequisites'
            ])
            ->where([
                ['level_id', $this->levelId],
                ['term_id', $this->semesterId],
            ])->firstOrFail();

        $registrations = Models\Registration::where('student_id', auth()->user()->student->id)
            ->whereIn('status_id', [4,6])
            ->get();
        $registrationsIds = $registrations->pluck('id')->toArray();

        $grades = Models\Grade::whereIn('registration_id', $registrationsIds)->get();

        if (filled($registrations) && filled($grades)) {
            foreach ($grades as $grade) {
                $this->grades[$grade->prospectus_subject->subject->id] = ['prospectusSubjectId' => $grade->prospectus_subject->subject->id, 'mark' => $grade->mark->name_element,
                    'value' => $grade->value ?? 'N/A'];
            }
        }
    }

    public function render() { return
        view('livewire.student.student-grade-view-component');
    }

    public function getProspectusesProperty() { return
        Models\Prospectus::select('level_id')
            ->groupBy(['level_id'])
            ->get();
    }

    public function getTermsProperty() { return
        Models\Term::get(['id', 'term']);
    }
}
