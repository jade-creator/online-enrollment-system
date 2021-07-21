<?php

namespace App\Services;

use App\Models\Mark;

class Remarks
{
    public $mark;

    public function getMark($grade)
    {
        $remarks = Mark::get(['id', 'name']);

        if ($grade <= 50) {
            $this->mark = $remarks->where('name', 'Dropped')->first();
        }

        if ($grade > 50 && $grade < 75) {
            $this->mark = $remarks->where('name', 'Failed')->first();
        }

        if ($grade >= 75 && $grade <= 100) {
            $this->mark = $remarks->where('name', 'Passed')->first();
        }

        return $this->mark->id ?? false;
    }
}