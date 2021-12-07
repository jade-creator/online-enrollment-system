<?php

namespace App\Services\Registration;

use App\Models;

class RegistrationIrregularService
{
    public function calculateTotalUnit(Models\Prospectus $prospectus, array $selected) : int
    {
        $subjects = $prospectus->subjects->filter(fn ($subject) => in_array($subject->id, $selected));

        return $subjects->sum('unit');
    }

    /**
     * @throws \Exception
     */
    public function store($prospectuses, int $studentId, int $curriculumId, array $selected = []) : Models\Registration
    {
        if (empty($selected) || empty($selected[0])) throw new \Exception('No subject/s found. Unable to register.');

        $registrationService = new RegistrationService();
        $registrationMain = NULL;
        $extensions = array();
        $registrationIds = array();

        //create registrations and extensions if any.
        foreach ($prospectuses as $index => $prospectus) {
            if (is_array($selected) && empty($selected[$index])) continue;

            if ($index == 0) {
                $registration = $registrationService->createNewRegistration($prospectus->id, $studentId, $curriculumId, $this->calculateTotalUnit($prospectus, $selected[0]));
                $registrationMain = $registrationService->store($selected[0], $registration);

                array_push($registrationIds, $registrationMain->id);
            } else {
                $registration = $registrationService->createNewRegistration($prospectus->id, $studentId, $curriculumId, $this->calculateTotalUnit($prospectus, $selected[$index]), true);
                $registration = $registrationService->store($selected[$index], $registration);

                array_push($registrationIds, $registration->id);

                $extension = new Models\Extension();
                $extension->extension_id = $registration->id;
                $extension->registration_id = $registrationMain->id;
                $extensions[] = $extension;
            }
        }

        //attach extensions to main registration if any.
        if (is_array($selected) && sizeof($selected) > 1 && $registrationMain != NULL) $registrationMain->extensions()->saveMany($extensions);

        return $registrationMain;
    }

    /**
     * @throws \Exception
     */
    public function update(Models\Registration $registration, $prospectuses, int $curriculumId, array $selected = []) : Models\Registration
    {
        $registrationService = new RegistrationService();

        $registrationService->detachGrades($registration);

        $extensions = [];

        foreach ($prospectuses as $index => $prospectus) {
            if ($index == 0) {
                $registration->section_id = NULL;
                $registration->prospectus_id = $prospectus->id;
                $registration->isRegular = 0;
                $registration->total_unit = $this->calculateTotalUnit($prospectus, $selected[0]);
                $registration->curriculum_id = $curriculumId;
                $registration->update();

                $registration = $registrationService->store($selected[0], $registration);
            } else {
                $registrationExtension = $registrationService->createNewRegistration($prospectus->id, $registration->student_id, $curriculumId, $this->calculateTotalUnit($prospectus, $selected[$index]), true);
                $registrationExtension = $registrationService->store($selected[$index], $registrationExtension);

                $extension = new Models\Extension();
                $extension->extension_id = $registrationExtension->id;
                $extension->registration_id = $registration->id;
                $extensions[] = $extension;
            }
        }

        if (is_array($selected) && sizeof($selected) > 1) $registration->extensions()->saveMany($extensions);

        return $registration;
    }
}
