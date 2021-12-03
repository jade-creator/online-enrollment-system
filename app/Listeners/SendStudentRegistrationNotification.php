<?php

namespace App\Listeners;

use App\Events\StudentPreRegistered;
use App\Notifications\NewRegistrationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendStudentRegistrationNotification
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
     * @param  StudentPreRegistered  $event
     * @return void
     */
    public function handle(StudentPreRegistered $event)
    {
        Notification::send($event->registration->student->user, (new NewRegistrationNotification($event->registration, $event->user)));
    }
}
