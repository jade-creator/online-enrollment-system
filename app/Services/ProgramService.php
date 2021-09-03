<?php

namespace App\Services;

use App\Models\Program;
use App\Services\Prospectus\ProspectusService;

class ProgramService
{
    public function store(Program $program) : Program
    {
        $program->save();

        (new ProspectusService())->store($program);

        return $program;
    }

    public function update(Program $program) : Program
    {
        $program->update();

        return $program;
    }

    public function destroy(Program $program) : Program
    {
        $program->delete();

        return $program;
    }
}
