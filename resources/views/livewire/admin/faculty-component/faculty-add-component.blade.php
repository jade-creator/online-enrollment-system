<div class="w-full scrolling-touch">
    <div class="h-content w-full py-8 px-8">
        <x-table.title tableTitle="Faculty Maintenance"></x-table.title>

        <x-table.main>
            <x-slot name="filter"></x-slot>
            <x-slot name="paginationLink"></x-slot>
            <x-slot name="head"></x-slot>

            <x-slot name="body">
                <div class="grid place-items-center">
                    <x-jet-form-section submit="" class="w-3/4">
                        <x-slot name="title">
                            Create New Faculty
                        </x-slot>

                        <x-slot name="description">Please fill out the form with correct data.</x-slot>

                        <x-slot name="form">
                            <form>
                                <div class="col-span-6">
                                    <x-jet-label for="name" value="{{ __('Name') }}" />
                                    <x-jet-input wire:model.defer="faculty.name" id="name" type="text" name="name" autofocus required/>
                                    <x-jet-input-error for="faculty.name" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="program_id" value="{{ __('Program') }}" />
                                    <select wire:model.defer="faculty.program_id" id="program_id" name="program_id" autofocus required>
                                        <option value="" selected>-- select a program --</option>
                                        @forelse ($this->programs as $program)
                                            <option value="{{ $program->id }}">{{ $program->program }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="faculty.program_id" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="description" value="{{ __('Description') }}" />
                                    <textarea wire:model.defer="faculty.description" type="text" id="description" name="description" autofocus required></textarea>
                                    <x-jet-input-error for="faculty.description" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="mission" value="{{ __('Mission') }}" />
                                    <textarea wire:model.defer="faculty.mission" type="text" id="mission" name="mission" autofocus required></textarea>
                                    <x-jet-input-error for="faculty.mission" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="vision" value="{{ __('Vision') }}" />
                                    <textarea wire:model.defer="faculty.vision" type="text" id="vision" name="vision" autofocus required></textarea>
                                    <x-jet-input-error for="faculty.vision" class="mt-2"/>
                                </div>
                            </form>
                        </x-slot>

                        <x-slot name="actions">
                            <a href="{{ route('admin.faculties.view') }}">
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
