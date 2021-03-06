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
    ];

    public function rules()
    {
        return [
            'photo' => ['nullable', 'image', 'max:1024'],
            'setting.school_name' => ['required', 'max:100', 'string'],
            'setting.school_email' => ['required', 'max:100', 'string'],
            'setting.school_address' => ['required', 'max:200', 'string'],
            'setting.school_description' => ['nullable', 'max:1000', 'string'],
            'setting.auto_account_approval' => ['required', 'boolean'],
            'setting.max_slots' => ['required', 'numeric', 'min:1'],
            'setting.downpayment_minimum_percentage' => ['required', 'numeric', 'min:1', 'max:100'],
            'setting.penalty_percentage' => ['required', 'numeric', 'min:1', 'max:100'],
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
        unset($rules['setting.auto_account_approval'],
              $rules['setting.downpayment_minimum_percentage'],
              $rules['setting.penalty_percentage']);

        $this->validate($rules);

        try {
            if (filled($this->photo)) {
                $uploadUrl = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($this->photo->getRealPath())->getSecurePath();

                $this->setting->profile_photo_path = $uploadUrl ?? NULL;
            }

            $this->setting->update();

            $this->sessionFlashAlert('alert', 'success', 'School Information Updated Successfully.');

            if (filled($this->photo)) return redirect()->route('admin.settings');
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
            return redirect()->route('admin.settings');
        } catch (\Exception $e) {
            $this->sessionFlashAlert('alert', 'danger', $e->getMessage(), FALSE);
        }
    }

    public function updateProcess()
    {
        $this->validateOnly('setting.auto_account_approval');

        try {
            $this->setting->update(['auto_account_approval' => $this->setting->auto_account_approval,]);

            $this->sessionFlashAlert('alert', 'success', 'Processes updated successfully.');
        } catch (\Exception $e) {
            $this->sessionFlashAlert('alert', 'danger', $e->getMessage(), FALSE);
        }
    }

    public function updatePayments()
    {
        $this->validateOnly('setting.downpayment_minimum_percentage');
        $this->validateOnly('setting.penalty_percentage');

        try {
            $this->setting->update([
                'downpayment_minimum_percentage' => $this->setting->downpayment_minimum_percentage,
                'penalty_percentage' => $this->setting->penalty_percentage,
            ]);

            $this->sessionFlashAlert('alert', 'success', 'Payments updated successfully.');
        } catch (\Exception $e) {
            $this->sessionFlashAlert('alert', 'danger', $e->getMessage(), FALSE);
        }
    }
}
