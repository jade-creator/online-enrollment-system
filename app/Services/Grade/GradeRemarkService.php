<?php

namespace App\Services\Grade;

use App\Models\Mark;
use Illuminate\Database\Eloquent\Collection;

class GradeRemarkService
{
    private $remarks;

    /**
     * @throws \Exception
     */
    public function findRemark(string $name) : int
    {
        $remark = $this->remarks->where('name', $name)->first();

        if(is_null($remark)) throw new \Exception('Remark is missing');

        return $remark->id;
    }

    /**
     * @throws \Exception
     */
    public function getMark($grade) : int
    {
        $this->remarks = Mark::get(['id', 'name']);

        switch($grade) {
            case $grade <= 50:
                return $this->findRemark('Dropped');
                break;

            case $grade > 50 && $grade < 75:
                return $this->findRemark('Failed');
                break;

            case $grade >= 75 && $grade <= 100:
                return $this->findRemark('Passed');
                break;

            default:
                throw new \Exception('Error: unremarked grade.');
        }
    }
}
