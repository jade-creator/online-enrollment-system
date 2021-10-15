<?php

namespace App\Http\Livewire\Admin\CurriculumComponent;

use App\Exports\CurriculaExport;
use App\Models;
use App\Services\CurriculumService;
use App\Traits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire;

class CurriculumIndexComponent extends Livewire\Component
{
    use AuthorizesRequests;
    use Livewire\WithPagination, Traits\WithBulkActions, Traits\WithSorting, Traits\WithFilters, Traits\WithExporting,
        Traits\WithSweetAlert;

    public Models\Curriculum $curriculum;
    public int $paginateValue = 10;

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
    ];

    protected $updatesQueryString = [
        'search',
    ];

    protected array $allowedSorts = ['code'];

    protected $listeners = [
        'refresh' => '$refresh',
        'DeselectPage' => 'updatedSelectPage',
        'activateOrDeactivateCurriculum',
        'fileExport',
    ];

    public function render() { return
        view('livewire.admin.curriculum-component.curriculum-index-component', ['curricula' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return Models\Curriculum::search($this->search)
            ->select(['id', 'code', 'program_id', 'description', 'isActive', 'start_date', 'end_date','created_at'])
            ->with('program.prospectuses')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->dateFiltered($this->dateMin, $this->dateMax);
    }

    public function activateOrDeactivateCurriculum()
    {
        try {
            $this->curriculum->isActive = !$this->curriculum->isActive;
            $curriculum = (new CurriculumService())->store($this->curriculum);

            $state = $curriculum->isActive ? 'activated.' : 'deactivated.';
            $this->success($curriculum->code.' has been '.$state);
            $this->emitSelf('refresh');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function confirmActivateCurriculum(Models\Curriculum $curriculum)
    {
        $curriculumActive = Models\Curriculum::where([
            ['program_id', $curriculum->program->id],
            ['isActive', 1],
            ['id', '!=', $curriculum->id]
        ])->first();

        $this->curriculum = $curriculum;
        if ($curriculumActive) {
            return $this->confirm('activateOrDeactivateCurriculum', $curriculumActive->code.' is currenlty active. Do you want to replace it?');
        } else {
            return $this->confirm('activateOrDeactivateCurriculum', 'Are you sure?');
        }
    }

    public function fileExport()
    {
        try {
            return $this->excelFileExport((new CurriculaExport($this->selected)), 'curriculum-collection.xlsx');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
