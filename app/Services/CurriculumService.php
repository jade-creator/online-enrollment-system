<?php

namespace App\Services;

use App\Models\Curriculum;
use App\Models\Program;

class CurriculumService
{
    public function store(Curriculum $curriculum) : Curriculum
    {
        if ($curriculum->isActive) {
            Curriculum::where('program_id', $curriculum->program->id)->update([
               'isActive' => 0,
            ]);
        }

        $curriculum->save();

        return $curriculum;
    }

    public function update(Curriculum $curriculum) : Curriculum
    {
        $curriculum->update();

        return $curriculum;
    }

    public function destroy(Curriculum $curriculum) : Curriculum
    {
        $curriculum->delete();

        return $curriculum;
    }
}
