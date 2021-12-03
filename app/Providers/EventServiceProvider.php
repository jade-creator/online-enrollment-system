<?php

namespace App\Providers;

use App\Events\RegistrationStatusUpdated;
use App\Events\StudentPreRegistered;
use App\Listeners\SendRegistrationStatusNotification;
use App\Listeners\SendStudentRegistrationNotification;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        StudentPreRegistered::class => [
            SendStudentRegistrationNotification::class,
        ],
        RegistrationStatusUpdated::class => [
            SendRegistrationStatusNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }
}
