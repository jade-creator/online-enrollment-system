<?php

namespace App\Http\Livewire\Admin\AdvisingComponent;

use App\Models;
use App\Rules\ZoomMeetLink;
use App\Services\AdvisingService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class AdvisingAddComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Advice $advice;
    public string $startTime = '', $endTime = '';

    public function rules()
    {
        return [
            'startTime' => ['required'],
            'endTime' => ['required', 'after:startTime'],
            'advice.date' => ['required'],
            'advice.program_id' => ['nullable'],
            'advice.level_id' => ['nullable'],
            'advice.link' => ['required', 'string', 'max:100', new ZoomMeetLink(), 'unique:advice,link'],
            'advice.remarks' => ['nullable'],
        ];
    }

    protected $messages = [
        'startTime.required' => 'The start time field cannot be empty.',
        'endTime.required' => 'The end time field cannot be empty.',
        'advice.date.required' => 'The date/s field cannot be empty.',
        'advice.link.required' => 'The Zoom Meet link field cannot be empty.',
        'advice.link.max' => 'The Zoom Meet link field is limited to 100 characters.',
        'advice.link.unique' => 'The Zoom Meet link provided is already in use.',
    ];

    public function mount() {
        $this->advice = new Models\Advice();
    }

    public function render() { return
        view('livewire.admin.advising-component.advising-add-component');
    }

    public function save()
    {
        $this->validate();

        try {
            $this->authorize('create', Models\Advice::class);
            (new AdvisingService())->store($this->startTime, $this->endTime, $this->advice);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => 'Advising schedule has been added.',
            ]);
            return redirect(route('admin.advising.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function getProgramsProperty() { return
        Models\Program::get(['id', 'code']);
    }
}
