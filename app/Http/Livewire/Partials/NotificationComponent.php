<?php

namespace App\Http\Livewire\Partials;

use App\Events\NotificationUpdatedCount;
use App\Traits\WithSweetAlert;
use Livewire\Component;

class NotificationComponent extends Component
{
    use WithSweetAlert;

    public function getListeners() : array
    {
        return [
            'refresh-notification-component:'.auth()->user()->id => '$refresh'
        ];
    }

    public function render()
    {
        return view('livewire.partials.notification-component', [
            'notifications' => auth()->user()->notifications,
            'unreadNotificationsCount' => count(auth()->user()->unreadNotifications),
        ]);
    }

    public function markAllAsRead()
    {
        try {
            auth()->user()->notifications->markAsRead();

            //dispatch event
            NotificationUpdatedCount::dispatch(auth()->user()->id);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
