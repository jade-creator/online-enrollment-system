<div class="w-full">
    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Subject Maintenance"></x-table.title>

        <x-table.main>
            <x-slot name="filter"></x-slot>
            <x-slot name="paginationLink"></x-slot>
            <x-slot name="head"></x-slot>

            <x-slot name="body">
                <div class="grid place-items-center">
                    <x-jet-form-section submit="" class="w-11/12 md:w-3/4">
                        <x-slot name="title">
                            <p class="capitalize">{{ $subject->title }}</p>
                        </x-slot>

                        <x-slot name="description">Please fill out the form with correct data.</x-slot>

                        <x-slot name="form">
                            <form>
                                <div class="col-span-6">
                                    <x-jet-label for="subject-code" value="{{ __('Code') }}" />
                                    <x-jet-input wire:model.defer="subject.code" id="subject-code" type="text" name="subject-code" autofocus/>
                                    <x-jet-input-error for="subject.code" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="subject-title" value="{{ __('Title') }}" />
                                    <x-jet-input wire:model.defer="subject.title" id="subject-title" type="text" name="subject-title" autofocus/>
                                    <x-jet-input-error for="subject.title" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="subject-description" value="{{ __('Description') }}" />
                                    <textarea wire:model.defer="subject.description" id="subject-description" name="subject-description" autofocus></textarea>
                                    <x-jet-input-error for="subject.description" class="mt-2"/>
                                </div>
                            </form>
                        </x-slot>

                        <x-slot name="actions">
                            <a href="{{ route('admin.subjects.view') }}">
                                <x-jet-secondary-button>
                                    {{ __('Cancel') }}
                                </x-jet-secondary-button>
                            </a>

                            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="update" wire:loading.attr="disabled">
                                {{ __('Update') }}
                            </x-jet-button>
                        </x-slot>
                    </x-jet-form-section>
                    <x-jet-section-border/>
                </div>
            </x-slot>
        </x-table.main>
    </div>
</div>
