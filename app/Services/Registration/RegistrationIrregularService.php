<?php

namespace App\Services\Registration;

use App\Models;

class RegistrationIrregularService
{
    public function createNewRegistration(int $prospectusId, int $studentId,  int $isExtension = 0) : Models\Registration
    {
        $registration = new Models\Registration();
        $registration->prospectus_id = $prospectusId;
        $registration->student_id = $studentId;
        $registration->isRegular = 0;
        $registration->isExtension = $isExtension;

        return $registration;
    }

    /**
     * @throws \Exception
     */
    public function store($prospectuses, int $studentId, array $selected = []) : Models\Registration
    {
        if (empty($selected) || empty($selected[0])) throw new \Exception('No subject/s found. Unable to register.');

        $registrationService = new RegistrationService();
        $registrationMain = NULL;
        $extensions = [];

        foreach ($prospectuses as $index => $prospectus) {
            if (is_array($selected) && empty($selected[$index])) continue;

            if ($index == 0) {
                $registration = $this->createNewRegistration($prospectus->id, $studentId);
                $registrationMain = $registrationService->store($selected[0], $registration);
            } else {
                $registration = $this->createNewRegistration($prospectus->id, $studentId, 1);
                $registration = $registrationService->store($selected[$index], $registration);

                $extension = new Models\Extension();
                $extension->extension_id = $registration->id;
                $extension->registration_id = $registrationMain->id;
                $extensions[] = $extension;
            }
        }

        if (is_array($selected) && sizeof($selected) > 1 && $registrationMain != NULL) $registrationMain->extensions()->saveMany($extensions);

        return $registrationMain;
    }
}
