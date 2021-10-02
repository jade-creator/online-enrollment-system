<?php

namespace App\Http\Livewire\Admin\AdvisingComponent;

use App\Models;
use App\Rules\ZoomMeetLink;
use App\Services\AdvisingService;
use App\Traits\WithSweetAlert;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class AdvisingUpdateComponent extends Component
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
            'advice.link' => ['required', 'string', 'max:100', new ZoomMeetLink()],
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
        list($this->startTime, $this->endTime) = explode( '-', $this->advice->time);
        $this->startTime = Carbon::parse($this->startTime)->format('H:i:s');
        $this->endTime = Carbon::parse($this->endTime)->format('H:i:s');
    }

    public function render() { return
        view('livewire.admin.advising-component.advising-update-component');
    }

    public function update()
    {
        $this->validate();

        try {
            $this->authorize('update', $this->advice);
            (new AdvisingService())->update($this->startTime, $this->endTime, $this->advice);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => 'Advising schedule has been updated.',
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
