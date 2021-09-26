<div class="w-full scrolling-touch">

    <div class="h-content w-full py-8 px-8">
        <x-table.title tableTitle="Fee Maintenance">
            <x-table.nav-button wire:click="$emit('modalAddingCategory')" wire:loading.attr="disabled">
                Create New Category
            </x-table.nav-button>
        </x-table.title>

        <x-table.main>
            <x-slot name="filter"></x-slot>

            <x-slot name="paginationLink"></x-slot>

            <x-slot name="head"></x-slot>

            <x-slot name="body">
                <div class="grid place-items-center">
                    <x-jet-form-section submit="" class="w-3/4">
                        <x-slot name="title">
                            Create New Fee
                        </x-slot>

                        <x-slot name="description">lorem ipsum woalala beng beng iskiri</x-slot>

                        <x-slot name="form">
                            <form>
                                <div class="col-span-3">
                                    <x-jet-label value="{{ __('Program Name') }}"/>
                                    <select wire:model.defer="fee.program_id" wire:loading.attr="disabled" name="program">
                                        @forelse ($this->programs as $program)
                                            @if ($loop->first)
                                                <option value="" selected>-- choose a program --</option>
                                            @endif
                                            <option value="{{ $program->id ?? 'N/A' }}">{{ $program->code ?? 'N/A' }}</option>
                                        @empty
                                            <option value="">No records</option>
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="fee.program_id" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label value="{{ __('Category Name') }}"/>
                                    <select wire:model.defer="fee.category_id" wire:loading.attr="disabled" name="category">
                                        @forelse ($this->categories as $category)
                                            @if ($loop->first)
                                                <option value="" selected>-- choose a category --</option>
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
                                    <textarea wire:model.defer="description" wire:loading.attr="disabled" name="description"></textarea>
                                    <x-jet-input-error for="description" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label value="{{ __('Amount') }}"/>
                                    <input wire:model.defer="price" wire:loading.attr="disabled" name="amount" type="number" min="1">
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

    <div wire:loading>
        @include('partials.loading')
    </div>

    <livewire:admin.fee-component.fee-category-add-component key="{{ 'admin-fee-category-add-component'.now() }}">
</div>
