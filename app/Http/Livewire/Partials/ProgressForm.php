<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class ProgressForm extends Component
{
    public $step = 1;
    protected $listeners = ['proceed'];

    public function render()
    {
        return view('livewire.partials.progress-form');
    }

    public function proceed($step){
        $this->step = $step;
    }
}
