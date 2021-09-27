<div class="w-full scrolling-touch">
    <div class="h-content w-full py-8 px-8">
        <x-table.title tableTitle="Section Maintenance"></x-table.title>

        <x-table.main>
            <x-slot name="filter"></x-slot>
            <x-slot name="paginationLink"></x-slot>
            <x-slot name="head"></x-slot>

            <x-slot name="body">
                <div class="grid place-items-center">
                    <x-jet-form-section submit="" class="w-3/4">
                        <x-slot name="title">
                            Create New Section
                        </x-slot>

                        <x-slot name="description">lorem ipsum woalala beng beng iskiri</x-slot>

                        <x-slot name="form">
                            <form>
                                <div class="col-span-3">
                                    <x-jet-label for="name" value="{{ __('Name') }}" />
                                    <x-jet-input wire:model.defer="section.name" id="name" type="text" name="name" autofocus required/>
                                    <x-jet-input-error for="section.name" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="seat" value="{{ __('Seat') }}" />
                                    <x-jet-input wire:model.defer="section.seat" id="seat" type="number" name="seat" autofocus required/>
                                    <x-jet-input-error for="section.seat" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="programId" value="{{ __('Program') }}" />
                                    <select wire:model.defer="programId" name="programId" autofocus required>
                                        <option value="" selected>-- choose a program --</option>
                                        @forelse ($this->programs as $program)
                                            <option value="{{ $program->id ?? 'N/A' }}">{{ $program->code ?? 'N/A' }}</option>
                                        @empty
                                            <option value="">No records</option>
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="programId" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="levelId" value="{{ __('Level') }}" />
                                    <select wire:model.defer="levelId" name="levelId" required>
                                        <option value="" selected>-- choose a level --</option>
                                        @forelse ($this->levels as $level)
                                            <option value="{{ $level->id ?? 'N/A' }}">{{ $level->level ?? 'N/A' }}</option>
                                        @empty
                                            <option value="">No records</option>
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="levelId" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="termId" value="{{ __('Term') }}" />
                                    <select wire:model.defer="termId" name="termId" required>
                                        <option value="" selected>-- choose a term --</option>
                                        @forelse ($this->terms as $term)
                                            <option value="{{ $term->id }}">{{ $term->term }}</option>
                                        @empty
                                            <option value="">No records</option>
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="termId" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="room" value="{{ __('Room') }}" />
                                    <select wire:model.defer="section.room_id" name="room" autofocus required>
                                        <option value="" selected>-- choose a room --</option>
                                        @forelse ($this->rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                                        @empty
                                            <option value="">No records</option>
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="section.room_id" class="mt-2"/>
                                </div>
                            </form>
                        </x-slot>

                        <x-slot name="actions">
                            <a href="{{ route('sections.view') }}">
                                <x-jet-secondary-button>
                                    {{ __('Cancel') }}
                                </x-jet-secondary-button>
                            </a>

                            <x-jet-button wire:click="save" wire:loading.attr="disabled" class="ml-2 bg-blue-500 hover:blue-700">
                                {{ __('Save') }}
                            </x-jet-button>
                        </x-slot>
                    </x-jet-form-section>
                    <x-jet-section-border/>
                </div>
            </x-slot>
        </x-table.main>
    </div>
</div>
