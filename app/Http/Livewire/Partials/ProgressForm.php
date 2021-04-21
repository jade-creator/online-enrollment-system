<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class ProgressForm extends Component
{
    public int $step = 1;
    protected $listeners = ['proceed'];

    public function render()
    {
        return view('livewire.partials.progress-form');
    }

    public function proceed(int $step){
        $this->step = $step;
    }
}
