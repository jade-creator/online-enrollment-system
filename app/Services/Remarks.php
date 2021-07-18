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
            $this->mark = $remarks->where('name', 'dropped')->first();
        }

        if ($grade > 50 && $grade < 75) {
            $this->mark = $remarks->where('name', 'failed')->first();
        }

        if ($grade >= 75 && $grade <= 100) {
            $this->mark = $remarks->where('name', 'passed')->first();
        }

        return $this->mark->id ?? false;
    }
}