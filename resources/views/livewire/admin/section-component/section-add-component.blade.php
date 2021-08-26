<x-jet-dialog-modal wire:model="addingSection">
    <x-slot name="title">
        {{ __('Section Maintenance') }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-4">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input wire:model.defer="section.name" id="name" class="block mt-1 w-full" type="text" name="name" autofocus required/>
                    <x-jet-input-error for="section.name" class="mt-2"/>
                </div>

                <div class="mt-4 col-span-4">
                    <x-jet-label for="seat" value="{{ __('Seat') }}" />
                    <x-jet-input wire:model.defer="section.seat" id="seat" class="block mt-1 w-full" type="number" name="seat" autofocus required/>
                    <x-jet-input-error for="section.seat" class="mt-2"/>
                </div>
            </div>

            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-4">
                    <x-jet-label for="program" value="{{ __('Program') }}" />
                    <select wire:model.defer="programId" name="program" class="w-full mt-1 bg-white flex-1 p-2 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                        @forelse ($this->programs as $program)
                            @if ($loop->first)
                                <option value="" selected>-- choose a program --</option>
                            @endif
                            <option value="{{ $program->id ?? 'N/A' }}">{{ $program->code ?? 'N/A' }}</option>
                        @empty
                            <option value="">No records</option>
                        @endforelse
                    </select>
                    <x-jet-input-error for="programId" class="mt-2"/>
                </div>

                <div class="mt-4 col-span-4">
                    <x-jet-label for="level" value="{{ __('Level') }}" />
                    <select wire:model.defer="levelId" name="level" class="w-full mt-1 bg-white flex-1 p-2 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                        @forelse ($this->levels as $level)
                            @if ($loop->first)
                                <option value="" selected>-- choose a level --</option>
                            @endif
                            <option value="{{ $level->id }}">{{ $level->level }}</option>
                        @empty
                            <option value="">No records</option>
                        @endforelse
                    </select>
                    <x-jet-input-error for="levelId" class="mt-2"/>
                </div>
            </div>

            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-4">
                    <x-jet-label for="term" value="{{ __('Term') }}" />
                    <select wire:model.defer="termId" name="term" class="w-full mt-1 bg-white flex-1 p-2 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                        @forelse ($this->terms as $term)
                            @if ($loop->first)
                                <option value="" selected>-- choose a term --</option>
                            @endif
                            <option value="{{ $term->id }}">{{ $term->term }}</option>
                        @empty
                            <option value="">No records</option>
                        @endforelse
                    </select>
                    <x-jet-input-error for="termId" class="mt-2"/>
                </div>

                <div class="mt-4 col-span-4">
                    <x-jet-label for="room" value="{{ __('Room') }}" />
                    <select wire:model.defer="section.room_id" name="room" class="w-full mt-1 bg-white flex-1 p-2 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                        @forelse ($this->rooms as $room)
                            @if ($loop->first)
                                <option value="" selected>-- choose a room --</option>
                            @endif
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @empty
                            <option value="">No records</option>
                        @endforelse
                    </select>
                    <x-jet-input-error for="section.room_id" class="mt-2"/>
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('addingSection')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="save" wire:loading.attr="disabled">
            {{ __('Add') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
