<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Fee Maintenance"></x-table.title>

        <x-table.main>
            <x-slot name="filter"></x-slot>

            <x-slot name="paginationLink"></x-slot>

            <x-slot name="head"></x-slot>

            <x-slot name="body">
                <div class="grid place-items-center">
                    <x-jet-form-section submit="" class="w-11/12 md:w-3/4">
                        <x-slot name="title">
                            Create New Fee
                        </x-slot>

                        <x-slot name="description">Please fill out the form with correct data.</x-slot>

                        <x-slot name="form">
                            <form>
                                <div class="col-span-3">
                                    <x-jet-label value="{{ __('Program') }}"/>
                                    <select wire:model.defer="fee.program_id" wire:loading.attr="disabled" name="program" class="truncate pr-5 mt-2">
                                        @forelse ($programs as $program)
                                            @if ($loop->first)
                                                <option value="" selected>Choose a program</option>
                                            @endif
                                            <option value="{{ $program->id ?? 'N/A' }}">{{ $program->code ?? 'N/A' }}</option>
                                        @empty
                                            <option value="">No records</option>
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="fee.program_id" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <div class="w-full flex items-center justify-between">
                                        <x-jet-label value="{{ __('Category') }}"/>

                                        <button wire:click.prevent="$emit('modalAddingCategory')" class="pb-2 text-xs text-indigo-500 hover:text-indigo-700 font-bold hover:underline focus:outline-none">
                                            Category List
                                        </button>
                                    </div>
                                    <select wire:model.defer="fee.category_id" wire:loading.attr="disabled" name="category" class="truncate pr-5">
                                        @forelse ($categories as $category)
                                            @if ($loop->first)
                                                <option value="" selected>Choose a category</option>
                                            @endif
                                            <option value="{{ $category->id ?? 'N/A' }}">{{ $category->name ?? 'N/A' }}</option>
                                        @empty
                                            <option value="">No records</option>
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="fee.category_id" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label value="{{ __('Description (optional)') }}"/>
                                    <textarea wire:model.defer="description" wire:loading.attr="disabled" name="description" class="h-32 mt-2"></textarea>
                                    <x-jet-input-error for="description" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label value="{{ __('Amount') }}"/>
                                    <input wire:model.defer="price" wire:loading.attr="disabled" name="amount" type="number" min="1" class="mt-2">
                                    <x-jet-input-error for="price" class="mt-2"/>
                                </div>
                            </form>
                        </x-slot>

                        <x-slot name="actions">
                            <a href="{{ route('admin.fees.view') }}">
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

    <div>@include('partials.loading')</div>

    <livewire:admin.fee-component.fee-category-add-component>
</div>
