<?php

namespace App\Traits;

use Carbon\Carbon;

trait WithFilters
{
    public $search = '';
    public $dateMin;
    public $dateMax;

    public function mountWithFilters()
    {
       $this->resetDates();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDateMin()
    {
        $this->resetPage();
    }

    public function updatingDateMax()
    {
        $this->resetPage();
    }

    public function resetDates()
    {
        $this->dateMin = null;
        $this->dateMax = Carbon::today()->addYears(100);
    }
}