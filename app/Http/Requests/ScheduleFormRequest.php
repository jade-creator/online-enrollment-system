<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'schedule.start_time_monday' => ['nullable'],
            'schedule.end_time_monday' => ['nullable', 'after:schedule.start_time_monday'],
            'schedule.start_time_tuesday' => ['nullable'],
            'schedule.end_time_tuesday' => ['nullable', 'after:schedule.start_time_tuesday'],
            'schedule.start_time_wednesday' => ['nullable'],
            'schedule.end_time_wednesday' => ['nullable', 'after:schedule.start_time_wednesday'],
            'schedule.start_time_thursday' => ['nullable'],
            'schedule.end_time_thursday' => ['nullable', 'after:schedule.start_time_thursday'],
            'schedule.start_time_friday' => ['nullable'],
            'schedule.end_time_friday' => ['nullable', 'after:schedule.start_time_friday'],
        ];
    }
}
