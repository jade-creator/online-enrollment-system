<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Masterlist extends Component
{
    public $view = 'table';

    public function changeView($view){
        $this->view = $view;
    }
    
    public function render()
    {
        return view('livewire.admin.masterlist');
    }
}
