<x-jet-dialog-modal wire:model="viewingSection">
    <x-slot name="title">
        {{ __('Section Maintenance') }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-4">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input wire:model.defer="section.name" class="block mt-1 w-full" type="text" name="name" autofocus required/>
                    <x-jet-input-error for="section.name" class="mt-2"/>
                </div>

                <div class="mt-4 col-span-4">
                    <x-jet-label for="room" value="{{ __('Room') }}" />
                    <select wire:model.defer="section.room_id" name="room" class="w-full mt-1 bg-white flex-1 p-2 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                        @forelse ($this->rooms as $room)
                            @if ($loop->first)
                                <option value="">-- choose a room --</option>
                            @endif
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @empty
                            <option value="">No records</option>
                        @endforelse
                    </select>
                    <x-jet-input-error for="section.room_id" class="mt-2"/>
                </div>
            </div>

            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-4">
                    <x-jet-label for="seat" value="{{ __('Seat') }}" />
                    <x-jet-input wire:model.defer="section.seat" class="block mt-1 w-full" type="number" name="seat" autofocus required/>
                    <x-jet-input-error for="section.seat" class="mt-2"/>
                </div>

                <div class="mt-4 col-span-4">
                    <x-jet-label for="currentNumberOfStudents" value="{{ __('Current no. of students') }}" />
                    <x-jet-input wire:model.defer="currentNumberOfStudents" class="block mt-1 w-full" type="number" name="currentNumberOfStudents" autofocus readonly/>
                    <x-jet-input-error for="currentNumberOfStudents" class="mt-2"/>
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('viewingSection')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button wire:click="update" wire:loading.attr="disabled" class="ml-2 bg-blue-500 hover:blue-700">
            {{ __('Update') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
