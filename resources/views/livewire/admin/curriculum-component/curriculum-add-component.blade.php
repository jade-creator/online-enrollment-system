<div class="w-full">
    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Curriculum Maintenance"></x-table.title>

        <x-table.main>
            <x-slot name="filter"></x-slot>
            <x-slot name="paginationLink"></x-slot>
            <x-slot name="head"></x-slot>

            <x-slot name="body">
                <div class="grid place-items-center">
                    <x-jet-form-section submit="" class="w-11/12 md:w-3/4">
                        <x-slot name="title">
                            Create New Curriculum
                        </x-slot>

                        <x-slot name="description">Please fill out the form with correct data.</x-slot>

                        <x-slot name="form">
                            <form>
                                <div class="col-span-6">
                                    <x-jet-label for="code" value="{{ __('Code') }}" />
                                    <x-jet-input wire:model.defer="curriculum.code" id="code" type="text" name="code" autofocus required/>
                                    <x-jet-input-error for="curriculum.code" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="description" value="{{ __('Description') }}" />
                                    <textarea wire:model.defer="curriculum.description" id="description" name="description" autofocus required></textarea>
                                    <x-jet-input-error for="curriculum.description" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="programId" value="{{ __('Program') }}" />
                                    <select wire:model.defer="curriculum.program_id" name="programID" required>
                                        <option value="" selected>-- choose a program --</option>
                                        @forelse ($this->programs as $program)
                                            <option value="{{ $program->id ?? 'N/A' }}">{{ $program->code ?? 'N/A' }}</option>
                                        @empty
                                            <option value="">No records</option>
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="curriculum.program_id" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="isActive" value="{{ __('State') }}" />
                                    <select wire:model.defer="curriculum.isActive" id="isActive" name="isActive" autofocus required>
                                        <option value="" selected>-- select a state --</option>
                                        <option value="1" selected>Active</option>
                                        <option value="0" selected>Inactive</option>
                                    </select>
                                    <x-jet-input-error for="curriculum.isActive" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="start_date" value="{{ __('Start Date') }}" />
                                    <x-jet-input wire:model.defer="curriculum.start_date" id="start_date" type="date" name="start_date" autofocus required/>
                                    <x-jet-input-error for="curriculum.start_date" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="end_date" value="{{ __('End Date') }}" />
                                    <x-jet-input wire:model.defer="curriculum.end_date" id="end_date" type="date" name="end_date" autofocus required/>
                                    <x-jet-input-error for="curriculum.end_date" class="mt-2"/>
                                </div>
                            </form>
                        </x-slot>

                        <x-slot name="actions">
                            <a href="{{ route('admin.curricula.view') }}">
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
