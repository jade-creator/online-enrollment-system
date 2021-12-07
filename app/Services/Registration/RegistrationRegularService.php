<?php

namespace App\Services\Registration;

use App\Jobs\CreatePreRegistration;
use App\Models;
use Illuminate\Support\Facades\Bus;

class RegistrationRegularService
{
    public function registerRegularStudents(Models\Prospectus $prospectus, Models\Section $section,
        string $notificationSenderUserId = '', string $curriculumId = '', array $studentIds = [])
    {
        if (empty($studentIds)) throw new \Exception('There are no students to enroll!');

        $jobs = array();

        $totalUnits = $prospectus->subjects->sum('unit');
        $subjectIds = $prospectus->subjects->pluck('id')->toArray();

        foreach ($studentIds as $studentId) {
            array_push($jobs, new CreatePreRegistration($prospectus->id, $studentId, $curriculumId, $section->id,
                $totalUnits,false,true, $subjectIds, $notificationSenderUserId));
        }

        $batch = Bus::batch($jobs)
            ->name($section->name." Pre Registrations' students")
            ->dispatch();

        //return the batch, create batch tracking progress component.
    }

    public function filterEligibleStudentIdsForEnrollment(array $registrationIds = [], string $curriculumId = '') : array
    {
        $registrations = Models\Registration::with([
                'assessment',
                'grades',
                'student' => function ($query) use ($curriculumId) {
                    $query->where('curriculum_id', $curriculumId);
                }
            ])
            ->find($registrationIds);

        $remark = Models\Mark::where('name', 'Passed')->first();

        $studentIds = array();

        foreach ($registrations as $registration) {

            //must have zero balance from the current registration.
            if ($registration->assessment->balance > 0) continue;

            //check if all subjects are passed.
            $markIds = array();

            foreach ($registration->grades as $grade) {
                array_push($markIds, $grade->mark_id);
            }

            if (array_unique($markIds) === array($remark->id)) {
                array_push($studentIds, $registration->student_id);
            }
        }

        if (empty(array_unique($studentIds))) throw new \Exception('There are no students eligible for next semester enrollment.');

        return array_unique($studentIds);
    }
}
