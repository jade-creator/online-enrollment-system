<?php

namespace App\Services;

use App\Models\Subject;

class SubjectService
{
    public function store(Subject $subject) { return
        $subject->save();
    }

    public function update(Subject $subject) { return
        $subject->update();
    }

    public function destroy(Subject $subject) { return
        $subject->delete();
    }
}
