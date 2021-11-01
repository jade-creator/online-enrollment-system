<?php

namespace App\Http\Livewire\Admin;

use App\Models\Setting;
use App\Traits\WithSweetAlert;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingsComponent extends Component
{
    use WithFileUploads;
    use WithSweetAlert;

    public Setting $setting;
    public $photo = NULL;

    protected $message = [
        'photo.image' => 'The profile must be a type of: img, png or jpg.',
        'photo.max' => 'Exceeded image size limit of 1024 bytes.',
        'setting.school_name.required' => 'The school name field cannot be empty.',
        'setting.school_email.required' => 'The school email field cannot be empty.',
        'setting.school_address.required' => 'The school address field cannot be empty.',
        'setting.school_description.required' => 'The school description field cannot be empty.',
    ];

    public function rules()
    {
        return [
            'photo' => ['nullable', 'image', 'max:1024'],
            'setting.school_name' => ['required', 'max:100', 'string'],
            'setting.school_email' => ['required', 'max:100', 'string'],
            'setting.school_address' => ['required', 'max:200', 'string'],
            'setting.school_description' => ['required', 'max:1000', 'string'],
            'setting.auto_account_approval' => ['required', 'boolean'],
            'setting.allow_irregular_student_to_enroll' => ['required', 'boolean'],
        ];
    }

    public function mount()
    {
        $this->setting = Setting::get()->first() ?? new Setting();
    }

    public function render() { return
        view('livewire.admin.settings-component');
    }

    public function updateSchoolInformation()
    {
        $rules = $this->rules();
        unset($rules['setting.auto_account_approval'], $rules['setting.allow_irregular_student_to_enroll']);

        $this->validate($rules);

        try {
            if ($this->photo) {
                $uploadUrl = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($this->photo->getRealPath())->getSecurePath();

                $this->setting->profile_photo_path = $uploadUrl ?? NULL;
            }

            $this->setting->update();

            $this->sessionFlashAlert('alert', 'success', 'School Information Updated Successfully.');
        } catch (\Exception $e) {
            $this->sessionFlashAlert('alert', 'danger', $e->getMessage(), FALSE);
        }
    }

    public function deleteProfilePhoto()
    {
        try {
            $this->setting->profile_photo_path = NULL;
            $this->setting->update();

            $this->sessionFlashAlert('alert', 'success', 'Logo Removed.');
        } catch (\Exception $e) {
            $this->sessionFlashAlert('alert', 'danger', $e->getMessage(), FALSE);
        }
    }

    public function updateProcess()
    {
        $this->validate([
            'setting.auto_account_approval' => ['required', 'boolean'],
            'setting.allow_irregular_student_to_enroll' => ['required', 'boolean']
        ]);

        try {
            $this->setting->update([
                'auto_account_approval' => $this->setting->auto_account_approval,
                'allow_irregular_student_to_enroll' => $this->setting->allow_irregular_student_to_enroll
            ]);

            $this->sessionFlashAlert('alert', 'success', 'Processes updated successfully.');
        } catch (\Exception $e) {
            $this->sessionFlashAlert('alert', 'danger', $e->getMessage(), FALSE);
        }
    }
}
