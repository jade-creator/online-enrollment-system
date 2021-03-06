<?php

namespace App\Providers;

use App\Events\CreateNotification;
use App\Listeners\SendNewNotification;
use App\Models\Assessment;
use App\Models\Registration;
use App\Models\Transaction;
use App\Models\User;
use App\Observers\AssessmentObserver;
use App\Observers\RegistrationObserver;
use App\Observers\TransactionObserver;
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
        CreateNotification::class => [
            SendNewNotification::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Assessment::observe(AssessmentObserver::class);
        Registration::observe(RegistrationObserver::class);
        User::observe(UserObserver::class);
        Transaction::observe(TransactionObserver::class);
    }
}
