<?php

namespace App\Http\Livewire\Admin\SectionComponent;

Use App\Models\Room;
use App\Traits\WithFilters;
use App\Traits\WithSweetAlert;
use Livewire\Component;
use Livewire\WithPagination;

class SectionRoomAddComponent extends Component
{
    use WithSweetAlert, WithFilters, WithPagination;

    public ?Room $room = NULL;
    public bool $addingRoom = FALSE, $add = FALSE;
    public int $paginateValue = 10;

    protected $listeners = [
        'modalAddingRoom',
        'confirmDeleteRoom'
    ];

    protected $messages = [
        'room.name.required' => 'The room field cannot be empty.',
    ];

    public function rules()
    {
        return [
            'room.name' => ['required', 'string', 'max:100', 'alpha_dash', 'unique:rooms,name'],
        ];
    }

    public function mount() {
        $this->room = new Room();
    }

    public function render() { return
        view('livewire.admin.section-component.section-room-add-component', ['rooms' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty() { return
        Room::select(['id', 'name'])
            ->orderBy('created_at', 'desc');
    }

    public function save()
    {
        if ($this->room->exists) {
            $this->validate([
                'room.name' => ['required', 'string', 'max:100', 'alpha_dash', 'unique:rooms,name,'.$this->room->id],
            ]);
        } else {
            $this->validate();
        }

        try {
            $this->room->save();

            $this->fill([
                'room' => new Room(),
                'add' => FALSE,
            ]);

            $this->emitUp('refresh');
        } catch (\Exception $e) {
            $this->emitUp('sessionFlashAlert', 'alert', 'danger', $e->getMessage());
        }
    }

    public function modalAddingRoom()
    {
        $this->resetValidation();
        $this->room = new Room();
        $this->toggleModal();
    }

    public function toggleModal() {
        $this->addingRoom = !$this->addingRoom;
    }

    public function confirmEditRoom(?Room $room = NULL)
    {
        $this->room = $room;
        $this->add = ! $this->add;
    }

    public function confirmDeleteRoom(?Room $room = NULL) {
        $this->room = $room;
    }

    public function deleteRoom() {
        if (is_null($this->room)) return;

        try {
            $this->room->delete();

            $this->emitUp('refresh');
        } catch (\Exception $e) {
            $this->emitUp('sessionFlashAlert', 'alert', 'danger', $e->getMessage());
        }
    }
}
