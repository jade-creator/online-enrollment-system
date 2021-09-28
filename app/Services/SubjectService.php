<?php

namespace App\Services;

use App\Models\Subject;

class SubjectService
{
    public function store(Subject $subject)
    {
        $subject->save();

        return $subject;
    }

    public function update(Subject $subject)
    {
        $subject->update();

        return $subject;
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return $subject;
    }
}
