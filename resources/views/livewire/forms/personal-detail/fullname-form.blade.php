<x-jet-form-section submit="updateFullname">
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
            <x-jet-input id="firstname" type="text" class="mt-1 block w-full" autocomplete="firstname" wire:model.defer="firstname"/>
            <x-jet-input-error for="firstname" class="mt-2"/>
        </div>

        <!-- mname -->
        <div class="col-span-6">
            <x-jet-label for="middlename" value="{{ __('Middle Name') }}"/>
            <x-jet-input id="middlename" type="text" class="mt-1 block w-full" autocomplete="middlename" wire:model.defer="middlename"/>
            <x-jet-input-error for="middlename" class="mt-2"/>
        </div>

        <!-- lname -->
        <div class="col-span-6">
            <x-jet-label for="lastname" value="{{ __('Last Name') }}" />
            <x-jet-input id="lastname" type="text" class="mt-1 block w-full" autocomplete="lastname" wire:model.defer="lastname"/>
            <x-jet-input-error for="lastname" class="mt-2"/>
        </div>

        <!-- suffix -->
        <div class="col-span-6">
            <x-jet-label for="suffix" value="{{ __('Suffix') }}" />
            <x-jet-input id="suffix" type="text" class="mt-1 block w-full" autocomplete="suffix" wire:model.defer="suffix"/>
            <x-jet-input-error for="suffix" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 bg-green-500 p-2 rounded-md text-white" on="saved">
            <i class="fas fa-check border-2 border-gray-200 rounded-full fill-current text-xs font-light text-gray-200"></i>
            {{ __('Updated Successfuly.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>