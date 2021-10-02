<?php

namespace App\Http\Livewire\Admin\AdvisingComponent;

use App\Models\Advice;
use App\Services\AdvisingService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class AdvisingDestroyComponent extends Component
{
    use AuthorizesRequests;
    use WithSweetAlert;

    protected $listeners = [
        'removeAdvice',
        'removeConfirm',
    ];

    public function render()
    {
        return <<<'blade'
            <div>
            </div>
        blade;
    }

    public function removeConfirm(Advice $advice) {
        $this->confirm('removeAdvice', 'Are you sure you want this deleted?', $advice);
    }

    public function removeAdvice(Advice $advice)
    {
        try {
            $this->authorize('destroy', $advice);
            (new AdvisingService())->destroy($advice);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => 'Advising Schedule has been deleted.',
            ]);
            return redirect(route('admin.advising.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
