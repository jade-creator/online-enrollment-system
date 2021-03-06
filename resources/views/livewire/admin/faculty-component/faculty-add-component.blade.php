<div class="w-full">
    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Faculty Maintenance"></x-table.title>

        <x-table.main>
            <x-slot name="filter"></x-slot>
            <x-slot name="paginationLink"></x-slot>
            <x-slot name="head"></x-slot>

            <x-slot name="body">
                <div class="grid place-items-center">
                    <x-jet-form-section submit="" class="w-11/12 md:w-3/4">
                        <x-slot name="title">
                            Create New Faculty
                        </x-slot>

                        <x-slot name="description">Please fill out the form with correct data.</x-slot>

                        <x-slot name="form">
                            <form>
                                <div class="col-span-6">
                                    <x-jet-label for="code" value="{{ __('Code') }}" />
                                    <x-jet-input wire:model.defer="faculty.code" id="code" type="text" name="code" autofocus required/>
                                    <x-jet-input-error for="faculty.code" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="name" value="{{ __('Name') }}" />
                                    <x-jet-input wire:model.defer="faculty.name" id="name" type="text" name="name" autofocus required/>
                                    <x-jet-input-error for="faculty.name" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="description" value="{{ __('Description') }}" />
                                    <textarea wire:model.defer="faculty.description" id="description" name="description" autofocus required></textarea>
                                    <x-jet-input-error for="faculty.description" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="mission" value="{{ __('Mission') }}" />
                                    <textarea wire:model.defer="faculty.mission" id="mission" name="mission" autofocus required></textarea>
                                    <x-jet-input-error for="faculty.mission" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="vision" value="{{ __('Vision') }}" />
                                    <textarea wire:model.defer="faculty.vision" id="vision" name="vision" autofocus required></textarea>
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
