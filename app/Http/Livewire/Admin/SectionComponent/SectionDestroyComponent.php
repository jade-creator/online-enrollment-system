<?php

namespace App\Http\Livewire\Admin\SectionComponent;

use App\Models\Section;
use App\Services\Section\SectionService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SectionDestroyComponent extends Component
{
    use AuthorizesRequests;
    use WithSweetAlert;

    protected $listeners = [ 'removeItem' ];

    public function render()
    {
        return <<<'blade'
            <div>
            </div>
        blade;
    }

    public function removeItem(Section $section)
    {
        $this->authorize('destroy', $section);

        try {
            $section = (new SectionService())->destroy($section);

            $this->emitUp('refresh');
            $this->success($section->name." has been deleted.");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
