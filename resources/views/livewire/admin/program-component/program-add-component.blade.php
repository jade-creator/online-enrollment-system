<div class="w-full">
    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Program Maintenance"></x-table.title>

        <x-table.main>
            <x-slot name="filter"></x-slot>
            <x-slot name="paginationLink"></x-slot>
            <x-slot name="head"></x-slot>

            <x-slot name="body">
                <div class="grid place-items-center">
                    <x-jet-form-section submit="" class="w-11/12 md:w-3/4">
                        <x-slot name="title">
                            Create New Program
                        </x-slot>

                        <x-slot name="description">Please fill out the form with correct data.</x-slot>

                        <x-slot name="form">
                            <form>
                                <div class="col-span-3">
                                    <x-jet-label for="code" value="{{ __('Code') }}" />
                                    <x-jet-input wire:model.defer="program.code" id="code" type="text" name="code" autofocus required/>
                                    <x-jet-input-error for="program.code" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="facultyId" value="{{ __('Faculty') }}" />
                                    <select wire:model.defer="program.faculty_id" name="facultyId" autofocus required>
                                        <option value="" selected>Select a faculty</option>
                                        @forelse ($this->faculties as $faculty)
                                            <option value="{{ $faculty->id ?? 'N/A' }}">{{ $faculty->code ?? 'N/A' }}</option>
                                        @empty
                                            <option value="">No records</option>
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="program.faculty_id" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="program" value="{{ __('Program') }}" />
                                    <x-jet-input wire:model.defer="program.program" id="program" type="text" name="program" autofocus required/>
                                    <x-jet-input-error for="program.program" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="year" value="{{ __('No. of Years') }}" />
                                    <x-jet-input wire:model.defer="program.year" id="year" type="number" name="year" min="1" max="5" autofocus required/>
                                    <x-jet-input-error for="program.year" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="description" value="{{ __('Description') }}" />
                                    <textarea wire:model.defer="program.description" id="description" name="description" autofocus required class="h-32"></textarea>
                                    <x-jet-input-error for="program.description" class="mt-2"/>
                                </div>
                            </form>
                        </x-slot>

                        <x-slot name="actions">
                            <a href="{{ route('admin.programs.view') }}">
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
