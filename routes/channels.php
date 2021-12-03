<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('pre-registration.{studentId}', function ($user, $studentId) {
    return (int) $user->student->id === (int) $studentId;
});

Broadcast::channel('notification-updated-count.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('registration-status.{studentId}', function ($user, $studentId) {
    return (int) $user->student->id === (int) $studentId;
});
