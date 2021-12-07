<?php

namespace App\Services\Grade;

use App\Models\Grade;
use App\Models\Registration;

class GradeService
{
    public function equivalency(float $value) : float
    {
        switch (true) {
            case ($value >= 74.50 && $value <= 76.49):
                $value = 3.00;
                break;

            case ($value >= 76.50 && $value <= 79.49):
                $value = 2.75;
                break;

            case ($value >= 79.50 && $value <= 82.49):
                $value = 2.50;
                break;

            case ($value >= 82.50 && $value <= 85.49):
                $value = 2.25;
                break;

            case ($value >= 85.50 && $value <= 88.49):
                $value = 2.00;
                break;

            case ($value >= 88.50 && $value <= 91.49):
                $value = 1.75;
                break;

            case ($value >= 91.50 && $value <= 94.49):
                $value = 1.50;
                break;

            case ($value >= 94.50 && $value <= 97.49):
                $value = 1.25;
                break;

            case ($value >= 97.50 && $value <= 100):
                $value = 1.00;
                break;

            default:
                $value = 5.00;
                break;
        }

        return $value;
    }

    /**
     * @throws \Exception
     */
    public function update(Grade $grade, string $type) : Grade
    {
        if ($type == 'scale') {
            if ($grade->value < 0 || $grade->value > 100) throw new \Exception('The grade must be between 0 and 100');

            $grade->isScale = 1;
            $grade->value = $this->equivalency(round($grade->value, 2));
            $grade->mark_id = (new GradeRemarkService())->getMark($grade->value, $type);
        } else {
            $grade->isScale = 0;
            $grade->value = $type == 'Dropped' ? 5 : null;
            $grade->mark_id = (new GradeRemarkService())->findRemark($type);
        }

        $grade->update();

        return $grade;
    }

    public function findStudentsGrade(array $registrationIds = [], string $prospectusSubjectId = '') : array
    {
        $registrations = Registration::with('grades')->find($registrationIds);
        $gradeIds = [];

        foreach ($registrations as $registration) {
            foreach ($registration->grades as $grade) {
                if ((int) $grade->subject_id === (int) $prospectusSubjectId) array_push($gradeIds, $grade->id);
            }
        }

        return $gradeIds;
    }

    /**
     * @throws \Exception
     */
    public function bulkUpdateThroughRegistrations(array $selected = [], string $prospectusSubjectId = '', string $type = '', string $value = '') : void
    {
        if (empty($selected)) throw new \Exception('No students selected.');

        $gradeIds = $this->findStudentsGrade($selected, $prospectusSubjectId);

        $gradeRemarkService = new GradeRemarkService();

        Grade::query()->when($type == 'scale', function ($query) use ($gradeIds, $value, $type, $gradeRemarkService) {
                if ($value > 0 && $value <= 100) {
                    $value = $this->equivalency(round($value, 2));

                    $query->whereIn('id', $gradeIds)->update([
                        'isScale' => 1,
                        'value' => $value,
                        'mark_id' => $gradeRemarkService->getMark($value, $type),
                    ]);
                };
            })
            ->when($type != 'scale', function ($query) use ($gradeIds, $type, $gradeRemarkService) {
                $query->whereIn('id', $gradeIds)->update([
                    'isScale' => 0,
                    'value' => $type == 'Dropped' ? 5 : null,
                    'mark_id' => $gradeRemarkService->findRemark($type),
                ]);
            });
    }
}
