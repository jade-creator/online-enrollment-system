<?php

namespace App\Services\Grade;

use App\Models\Grade;

class GradeService
{
    public function update(Grade $grade) : Grade
    {
        $grade->mark_id = (new GradeRemarkService())->getMark($grade->value);
        $grade->save();

        return $grade;
    }
}
