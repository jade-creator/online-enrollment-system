<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppSettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $setting = new Setting();
        $lifeTime = now()->addMinutes(10);

        if (Cache::missing('school_profile_photo_path')) {
            $setting = \App\Models\Setting::get()->first();
        }

        $data = [
            'school_profile_photo_path' => Cache::has('school_profile_photo_path')
                ? Cache::get('school_profile_photo_path') : $setting->profile_photo_url_preview ?? 'N/A',
            'school_name' => Cache::has('school_name')
                ? Cache::get('school_name') : $setting->school_name ?? 'N/A',
            'school_email' => Cache::has('school_email')
                ? Cache::get('school_email') : $setting->school_email ?? 'N/A',
            'school_address' => Cache::has('school_address')
                ? Cache::get('school_address') : $setting->school_address ?? 'N/A',
            'school_description' => Cache::has('school_description')
                ? Cache::get('school_description') : $setting->school_description ?? 'N/A',
        ];

        Cache::put($data, $lifeTime);

        View::share([
            'school_profile_photo_path' => $data['school_profile_photo_path'],
            'school_name' => $data['school_name'],
            'school_email' => $data['school_email'],
            'school_address' => $data['school_address'],
            'school_description' => $data['school_description']
        ]);
    }
}
