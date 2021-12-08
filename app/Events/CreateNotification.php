<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $senderId;
    public string $recipientId;
    public string $title;
    public string $body;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($senderId, $recipientId, $title, $body)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notification.'.$this->recipientId);
    }
}
