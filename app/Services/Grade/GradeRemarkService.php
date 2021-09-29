<?php

namespace App\Services\Grade;

use App\Models\Mark;
use Illuminate\Database\Eloquent\Collection;

class GradeRemarkService
{
    /**
     * @throws \Exception
     */
    public function findRemark(string $name) : int
    {
        $remarks = Mark::get(['id', 'name']);
        $remark = $remarks->where('name', $name)->first();

        if(is_null($remark)) throw new \Exception('Remark is missing');

        return $remark->id;
    }

    /**
     * @throws \Exception
     */
    public function getMark($grade, string $type) : int
    {
        switch($grade) {
            case $grade >= 1.00 && $grade <= 3.00:
                return $this->findRemark('Passed');

            case $grade > 3.00:
                return $this->findRemark('Failed');

            default:
                throw new \Exception('Error: unremarked grade.');
        }
    }
}
