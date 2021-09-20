<x-jet-dialog-modal wire:model="addingCategory">
    <x-slot name="title">
        {{ __('Add Category') }}
    </x-slot>

    <x-slot name="content">
        <div class="col-span-3">
            <x-jet-label value="{{ __('Category Name') }}"/>
            <input wire:model.defer="category.name" wire:loading.attr="disabled" name="category" type="text">
            <x-jet-input-error for="category.name" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('addingCategory')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="save" wire:loading.attr="disabled">
            {{ __('Add') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
