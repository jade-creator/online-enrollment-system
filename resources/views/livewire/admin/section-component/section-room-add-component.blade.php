<x-jet-dialog-modal wire:model="addingRoom" :closeBtn="true">
    <x-slot name="title">
        {{ __('Rooms') }}
    </x-slot>

    <x-slot name="content">
        @if ($add)
            <button wire:click.prevent="$toggle('add')" class="w-full h-full absolute top-0 bg-transparent z-0 focus:outline-none"></button>

            <div class="w-full px-6 py-4 bg-white z-50 relative shadow-lg">
                <x-jet-label value="{{ __('Room Name') }}"/>
                <input wire:model.defer="room.name" wire:loading.attr="disabled" name="category" type="text" class="text-sm mt-2">
                <x-jet-input-error for="room.name" class="mt-2"/>
            </div>
        @endif

        <div class="sidebar w-full px-6 max-h-72 overflow-x-hidden overflow-y-auto">
            @forelse ($rooms as $room)
                @if (filled($this->room) && $this->room->id == $room->id && ! $add)
                    <div class="flex items-center justify-between bg-red-500 rounded-md">
                        <div class="font-semibold pl-2 text-white">Are you sure ?</div>

                        <div class="flex items-center">
                            <button wire:click.prevent="confirmDeleteRoom" wire:loading.attr="disabled" class="text-xs text-white px-2 py-3 focus:outline-none">
                                Cancel
                            </button>
                            <button wire:click.prevent="deleteRoom" wire:loading.attr="disabled" class="text-xs bg-green-400 hover:bg-green-500 text-white px-2 py-3 focus:outline-none rounded-br-md rounded-tr-md">
                                Confirm
                            </button>
                        </div>
                    </div>
                @else
                    <div class="flex items-center justify-between px-2 py-3 hover:bg-gray-50 rounded-md">
                        <div class="font-semibold">{{ $room->name ?? 'N/A'}}</div>
                        <div class="flex items-center">
                            <button wire:click.prevent="confirmEditRoom({{$room}})" wire:loading.attr="disabled" class="text-indigo-500 hover:text-indigo-900 focus:outline-none mx-1" title="Edit">
                                <x-icons.edit-icon stroke-width="1" class="w-5 h-5 cursor-pointer"/>
                            </button>

                            <button wire:click.prevent="$emit('confirmDeleteRoom', {{$room}})" wire:loading.attr="disabled" class="text-red-500 hover:text-red-900 focus:outline-none" title="Delete">
                                <x-icons.delete-icon stroke-width="1" class="w-5 h-5 cursor-pointer"/>
                            </button>
                        </div>
                    </div>
                @endif
            @empty
                <div class="w-full h-40">
                    <p class="w-full text-sm text-gray-500 text-center">No result found.</p>
                </div>
            @endforelse

            @if (filled($rooms))
                {{ $rooms->links('partials.pagination-link') }}
            @endif
        </div>
    </x-slot>

    <x-slot name="footer">
        @if (! $add)
            <x-jet-button wire:click.prevent="$toggle('add')" class="ml-2 bg-blue-500 hover:blue-700">
                {{ __('Create New') }}
            </x-jet-button>
        @else
            <x-jet-secondary-button wire:click.prevent="$toggle('add')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button wire:click.prevent="save" wire:loading.attr="disabled" class="ml-2 bg-blue-500 hover:blue-700">
                {{ __('Save') }}
            </x-jet-button>
        @endif
    </x-slot>
</x-jet-dialog-modal>
