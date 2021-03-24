<x-jet-form-section submit="updateOrCreateFullname">
    <x-slot name="title">
        {{ __('Fullname') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your fullname information.') }}
    </x-slot>

    <x-slot name="form">
        <!-- fName -->
        <div class="col-span-6">
            <x-jet-label for="firstname" value="{{ __('First Name') }}" />
            <x-jet-input id="firstname" type="text" class="mt-1 block w-full" autocomplete="firstname" required wire:model.defer="firstname" wire:loading.attr="disabled"/>
            <x-jet-input-error for="firstname" class="mt-2"/>
        </div>

        <!-- mname -->
        <div class="col-span-6">
            <x-jet-label for="middlename" value="{{ __('Middle Name') }}"/>
            <x-jet-input id="middlename" type="text" class="mt-1 block w-full" autocomplete="middlename" required wire:model.defer="middlename" wire:loading.attr="disabled"/>
            <x-jet-input-error for="middlename" class="mt-2"/>
        </div>

        <!-- lname -->
        <div class="col-span-6">
            <x-jet-label for="lastname" value="{{ __('Last Name') }}" />
            <x-jet-input id="lastname" type="text" class="mt-1 block w-full" autocomplete="lastname" required wire:model.defer="lastname" wire:loading.attr="disabled"/>
            <x-jet-input-error for="lastname" class="mt-2"/>
        </div>

        <!-- suffix -->
        <div class="col-span-6">
            <x-jet-label for="suffix" value="{{ __('Suffix (Optional)') }}" />
            <x-jet-input id="suffix" type="text" class="mt-1 block w-full" autocomplete="suffix" wire:model.defer="suffix" wire:loading.attr="disabled"/>
            <x-jet-input-error for="suffix" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 p-2 text-green-500 font-bold" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>