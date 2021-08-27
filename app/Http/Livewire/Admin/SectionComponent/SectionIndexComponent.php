<?php

namespace App\Http\Livewire\Admin\SectionComponent;

use App\Exports\SectionsExport;
use App\Models;
use App\Services\Registration\RegistrationReleaseService;
use App\Traits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire;

class SectionIndexComponent extends Livewire\Component
{
    use AuthorizesRequests;
    use Livewire\WithPagination, Traits\WithBulkActions, Traits\WithSorting, Traits\WithFilters, Traits\WithExporting,
        Traits\WithSweetAlert;

    public Models\Section $section;
    public Models\Status $status;
    private RegistrationReleaseService $registrationReleaseService;
    public int $paginateValue = 10;
    public string $programId = '';

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
        'programId' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'search',
        'programId',
    ];

    protected $listeners = [
        'DeselectPage' => 'updatedSelectPage',
        'refresh' => '$refresh',
        'releaseStudents',
        'removeConfirm',
    ];

    protected array $allowedSorts = [
        'id',
        'name',
    ];

    public function mount()
    {
        $this->status = Models\Status::where('name', 'released')->firstOrFail();
        $this->registrationReleaseService = new RegistrationReleaseService($this->status->id);
    }

    public function render() { return
        view('livewire.admin.section-component.section-index-component', ['sections' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return Models\Section::search($this->search)
            ->select(['id', 'name', 'prospectus_id', 'room_id', 'seat', 'created_at'])
            ->with([
                'schedules.subject',
                'registrations' => function($query) {
                    return $query->enrolled();
                },
            ])
            ->filterWithProspectusByProgram($this->programId)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->dateFiltered($this->dateMin, $this->dateMax);
    }

    public function removeConfirm(Models\Section $section)
    {
        if ($section->registrations->isNotEmpty()) return $this->warning("There are students enrolled under ".$section->name);

        $this->confirmDelete('removeSection', $section, $section->name);
    }

    public function releaseConfirm(Models\Section $section)
    {
        $this->section = $section;

        $this->dispatchBrowserEvent('swal:confirmRelease', [
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => 'Students under this section will be removed. Their registration will be moved to history once successfull.',
        ]);
    }

    public function release(string $method, $argument)
    {
        try {
            $this->registrationReleaseService->$method($argument);
            $this->success('The students have been released.');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function releaseStudents() { $this->release('release', $this->section->registrations); }

    public function releaseAll() { $this->release('releaseAll', $this->selected); }

    public function getRoomsProperty() { return
        Models\Room::get(['id', 'name']);
    }

    public function getProgramsProperty() { return
        Models\Program::get(['id', 'code']);
    }

    public function fileExport() { return
        $this->excelFileExport((new SectionsExport($this->selected)), 'section-collection.xlsx');
    }
}
