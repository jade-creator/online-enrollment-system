<div class="w-full">
    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Section Maintenance"></x-table.title>

        <x-table.main>
            <x-slot name="filter"></x-slot>
            <x-slot name="paginationLink"></x-slot>
            <x-slot name="head"></x-slot>

            <x-slot name="body">
                <div class="grid place-items-center">
                    <x-jet-form-section submit="" class="w-11/12 md:w-3/4">
                        <x-slot name="title">
                            <p class="capitalize">{{ $section->name }}</p>
                        </x-slot>

                        <x-slot name="description">Please fill out the form with correct data.</x-slot>

                        <x-slot name="form">
                            <form>
                                <div class="col-span-6">
                                    <x-jet-label for="name" value="{{ __('Name') }}" />
                                    <x-jet-input wire:model.defer="section.name" id="name" type="text" name="name" autofocus required class="mt-2"/>
                                    <x-jet-input-error for="section.name" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="seat" value="{{ __('Available Seats') }}" />
                                    <x-jet-input id="seat" type="text" name="seat" class="mt-2 bg-gray-100 cursor-not-allowed" readonly value="{{ $school_max_slots_per_section }}"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="currentNumberOfStudents" value="{{ __('Current no. of Enrolled Students') }}" />
                                    <x-jet-input wire:model.defer="currentNumberOfStudents" type="number" name="currentNumberOfStudents" readonly class="mt-2 bg-gray-100 cursor-not-allowed"/>
                                    <x-jet-input-error for="currentNumberOfStudents" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="programId" value="{{ __('Program') }}" />
                                    <select wire:model.defer="programId" name="programId" autofocus required class="mt-2">
                                        <option value="" selected>Select a program</option>
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
                                    <select wire:model.defer="levelId" name="levelId" required class="mt-2">
                                        <option value="" selected>Select a level</option>
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
                                    <select wire:model.defer="termId" name="termId" required class="mt-2">
                                        <option value="" selected>Select a semester</option>
                                        @forelse ($this->terms as $term)
                                            <option value="{{ $term->id }}">{{ $term->term }}</option>
                                        @empty
                                            <option value="">No records</option>
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="termId" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <div class="w-full flex items-center justify-between">
                                        <x-jet-label value="{{ __('Rooms') }}"/>

                                        <button wire:click.prevent="$emit('modalAddingRoom')" class="pb-2 text-xs text-indigo-500 hover:text-indigo-700 font-bold hover:underline focus:outline-none">
                                            Room List
                                        </button>
                                    </div>

                                    <select wire:model.defer="section.room_id" name="room" autofocus required>
                                        <option value="" selected>Select a room</option>
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

                            <x-jet-button wire:click="update" wire:loading.attr="disabled" class="ml-2 bg-blue-500 hover:blue-700">
                                {{ __('Update') }}
                            </x-jet-button>
                        </x-slot>
                    </x-jet-form-section>
                    <x-jet-section-border/>
                </div>
            </x-slot>
        </x-table.main>
    </div>

    <livewire:admin.section-component.section-room-add-component>
</div>
