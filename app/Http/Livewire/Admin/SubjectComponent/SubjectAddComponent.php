<?php

namespace App\Http\Livewire\Admin\SubjectComponent;

use App\Models\Program;
use App\Models\SchoolType;
use App\Models\Strand;
use App\Models\Subject;
use App\Models\Term;
use Livewire\Component;

class SubjectAddComponent extends Component
{
    public Subject $subject;

    public function rules() 
    {
        return [
            'subject.code' => ['required', 'string', 'max:255'],
            'subject.title' => ['required', 'string', 'max:255'],
            'subject.unit' => ['required', 'integer', 'min:0'],
        ];     
    }

    public function render() { return 
        view('livewire.admin.subject-component.subject-add-component');
    }

    public function mount() 
    {
        $this->subject = new Subject();
    }

    public function create()    
    {       
        $this->validate();      
        $this->subject->save();

        return redirect(route('admin.subjects.view'));
    }
}
