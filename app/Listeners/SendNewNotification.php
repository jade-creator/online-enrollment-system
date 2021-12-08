<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\NewNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewNotification
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $sender = User::find($event->senderId);
        $recipient = User::find($event->recipientId);

        Notification::send($recipient, (new NewNotification($sender->profile_photo_url ?? '', $sender->person->shortFullName ?? '',
            $event->title, $event->body)));
    }
}
