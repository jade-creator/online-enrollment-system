<?php

namespace App\Services;

use App\Models\Advice;
use Carbon\Carbon;

class AdvisingService
{
    public function store($startTime, $endTime, Advice $advice) : Advice
    {
        $advice->time = Carbon::parse($startTime)->format('g:i A').'-'.Carbon::parse($endTime)->format('g:i A');
        $advice->save();

        return $advice;
    }

    public function update($startTime, $endTime, Advice $advice) : Advice
    {
        $advice->time = Carbon::parse($startTime)->format('g:i A').'-'.Carbon::parse($endTime)->format('g:i A');
        $advice->update();

        return $advice;
    }

    public function destroy(Advice $advice) : Advice
    {
        $advice->delete();

        return $advice;
    }
}
