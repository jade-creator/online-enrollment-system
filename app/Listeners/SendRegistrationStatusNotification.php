<?php

namespace App\Listeners;

use App\Events\RegistrationStatusUpdated;
use App\Models\Registration;
use App\Models\User;
use App\Notifications\RegistrationStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendRegistrationStatusNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RegistrationStatusUpdated  $event
     * @return void
     */
    public function handle(RegistrationStatusUpdated $event)
    {
        $registration = Registration::find($event->registrationId);
        $user = User::find($event->userId);
        $receiver = $registration->student->user;

        Notification::send($receiver, (new RegistrationStatusNotification($registration, $user, $event->message)));
    }
}
