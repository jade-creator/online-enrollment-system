<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Program;
use App\Models\Registration;
use App\Services\Prospectus\ProspectusService;

class ProgramService
{
    public function combineFees(Registration $registration, int $totalUnit = 0, bool $selectAll = true) : array
    {
        $fees = array();

        if ($registration->prospectus->program->fees->isNotEmpty()) {
            $category = Category::where('name', 'Tuition Fee (multiplied by unit/s)')->first();

            foreach ($registration->prospectus->program->fees as $fee) {
                $totalFee = $fee->price;
                if ($category && $fee->category_id == $category->id) $totalFee = $totalUnit * $fee->price;

                $fees[$fee->id] = [$selectAll, $totalFee];
            }
        }

        return $fees;
    }

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
