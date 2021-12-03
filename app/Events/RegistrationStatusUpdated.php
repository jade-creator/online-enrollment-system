<?php

namespace App\Events;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegistrationStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $registrationId;
    public $studentId;
    public $userId;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($registrationId, $studentId, $userId, $message = '')
    {
        $this->registrationId = $registrationId;
        $this->studentId = $studentId;
        $this->userId = $userId;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('registration-status.'.$this->studentId);
    }
}
