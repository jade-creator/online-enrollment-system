<?php

namespace App\Http\Livewire\Forms\User;

use App\Events\NotificationUpdatedCount;
use App\Traits\WithFilters;
use App\Traits\WithSweetAlert;
use Livewire\Component;
use Livewire\WithPagination;

class UserNotificationComponent extends Component
{
    use WithPagination, WithSweetAlert, WithFilters;

    public int $paginateValue = 10;

    protected $queryString = [
        'search' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'search',
    ];

    public function getListeners() : array
    {
        return [
            'refresh-user-notification-component:'.auth()->user()->id => '$refresh'
        ];
    }

    public function render()
    {
        return view('livewire.forms.user.user-notification-component', ['notifications' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return auth()->user()->notifications()
            ->where('id', 'LIKE', '%'.$this->search.'%');
    }

    public function markAsRead($notificationId)
    {
        try {
            $notification = auth()->user()->notifications()->find($notificationId);

            if ($notification) $notification->markAsRead();

            //dispatch event
            NotificationUpdatedCount::dispatch(auth()->user()->id);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
