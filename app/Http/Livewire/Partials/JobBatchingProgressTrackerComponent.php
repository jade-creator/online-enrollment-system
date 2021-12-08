<?php

namespace App\Http\Livewire\Partials;

use App\Services\SendNotification;
use Illuminate\Support\Facades\Bus;
use Livewire\Component;

class JobBatchingProgressTrackerComponent extends Component
{
    public string $batchId = '';
    public array $notificationInfo = [];

    protected $listeners = [
        'updateBatchId' => 'updateBatchIdOnQueue',
        'sendNotificationWhenFinished'
    ];

    public function render()
    {
        return view('livewire.partials.job-batching-progress-tracker-component', [
            'batch' => $this->batchOnQueue
        ]);
    }

    public function getBatchOnQueueProperty()
    {
        if (empty($this->batchId)) return null;

        $batch = Bus::findBatch($this->batchId);

        if (filled($batch) && $batch->finished()) {
            $this->dispatchBrowserEvent('stop-interval');

            if (filled($this->notificationInfo)) {
                (new SendNotification())->dispatch(...$this->notificationInfo);
            }

            return null;
        }

        return $batch;
    }

    public function updateBatchIdOnQueue($value) {
        $this->batchId = $value;
    }

    public function sendNotificationWhenFinished($value) {
        $this->notificationInfo = $value;
    }
}
