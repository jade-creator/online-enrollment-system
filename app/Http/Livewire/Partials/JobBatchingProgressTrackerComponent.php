<?php

namespace App\Http\Livewire\Partials;

use Illuminate\Support\Facades\Bus;
use Livewire\Component;

class JobBatchingProgressTrackerComponent extends Component
{
    public string $batchId = '';

    protected $listeners = [
        'updateBatchId',
    ];

    public function render()
    {
        return view('livewire.partials.job-batching-progress-tracker-component', [
            'batch' => $this->batch
        ]);
    }

    public function getBatchProperty()
    {
        if (empty($this->batchId)) return null;

        return Bus::findBatch($this->batchId);
    }

    public function updateBatchId($value) {
        $this->batchId = $value;
    }
}
