<div class="w-full">
    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Advising Schedule Maintenance">
            <a href="https://us05web.zoom.us/meeting/schedule" target="_blank">
                <x-table.nav-button>
                    Create Zoom Meeting Schedule
                </x-table.nav-button>
            </a>
        </x-table.title>

        <x-table.main>
            <x-slot name="filter"></x-slot>
            <x-slot name="paginationLink"></x-slot>
            <x-slot name="head"></x-slot>

            <x-slot name="body">
                <div class="grid place-items-center">
                    <x-jet-form-section submit="" class="w-11/12 md:w-3/4">
                        <x-slot name="title">
                            Create New Advising Schedule
                        </x-slot>

                        <x-slot name="description">Please fill out the form with correct data.</x-slot>

                        <x-slot name="form">
                            <form>
                                <div class="col-span-6">
                                    <x-jet-label for="date" value="{{ __('Date/s') }}" />
                                    <x-jet-input wire:model.defer="advice.date" id="date" type="text" name="date" autofocus required placeholder="eg. Jan. 12-14"/>
                                    <x-jet-input-error for="advice.date" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="start_time" value="{{ __('Start Time') }}" />
                                    <x-jet-input wire:model.defer="startTime" id="start_time" type="time" name="start_time" autofocus required/>
                                    <x-jet-input-error for="startTime" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="end_time" value="{{ __('End Time') }}" />
                                    <x-jet-input wire:model.defer="endTime" id="end_time" type="time" name="end_time" autofocus required/>
                                    <x-jet-input-error for="endTime" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="programId" value="{{ __('Program') }}" />
                                    <select wire:model.defer="advice.program_id" wire:loading.attr="disabled" name="programId">
                                        <option value="">All</option>
                                        @forelse ($this->programs as $program)
                                            <option value="{{ $program->id }}">{{ $program->code }}</option>
                                        @empty
                                            <option value="">No records</option>
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="advice.program_id" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="levelId" value="{{ __('Level') }}" />
                                    <select wire:model="advice.level_id" wire:loading.attr="disabled" name="levelId">
                                        <option value="">All</option>
                                        <option value="14">1st Year</option>
                                        <option value="15">2nd Year</option>
                                        <option value="16">3rd Year</option>
                                        <option value="17">4th Year</option>
                                        <option value="18">5th Year</option>
                                    </select>
                                    <x-jet-input-error for="advice.level_id" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="link" value="{{ __('Zoom Meeting link') }}" />
                                    <x-jet-input wire:model.defer="advice.link" id="link" type="text" name="link" autofocus required placeholder="https://us05web.zoom.us/..."/>
                                    <x-jet-input-error for="advice.link" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="remarks" value="{{ __('Remarks (optional)') }}" />
                                    <textarea wire:model.defer="advice.remarks" id="remarks" name="remarks" autofocus class="h-32"></textarea>
                                    <x-jet-input-error for="advice.remarks" class="mt-2"/>
                                </div>
                            </form>
                        </x-slot>

                        <x-slot name="actions">
                            <a href="{{ route('admin.advising.view') }}">
                                <x-jet-secondary-button>
                                    {{ __('Cancel') }}
                                </x-jet-secondary-button>
                            </a>

                            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="save" wire:loading.attr="disabled">
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
