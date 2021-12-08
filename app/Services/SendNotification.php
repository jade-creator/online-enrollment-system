<?php

namespace App\Services;

use App\Events\CreateNotification;

class SendNotification
{
    public function dispatch(string $senderId = '', string $recipientId = '', string $title = '', string $body = '')
    {
        CreateNotification::dispatch($senderId, $recipientId, $title, $body);
    }
}
