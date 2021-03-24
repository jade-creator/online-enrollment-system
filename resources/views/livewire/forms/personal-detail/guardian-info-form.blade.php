<x-jet-form-section submit="updateGuardian">
    <x-slot name="title">
        {{ __('Guardian Details') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your guardian information.') }}
    </x-slot>

    <x-slot name="form">
        <!-- fName -->
        <div class="col-span-6">
            <x-jet-label for="firstname" value="{{ __('First Name') }}" />
            <x-jet-input id="firstname" type="text" class="mt-1 block w-full" autocomplete="firstname" required wire:model.defer="firstname"/>
            <x-jet-input-error for="firstname" class="mt-2"/>
        </div>

        <!-- mname -->
        <div class="col-span-6">
            <x-jet-label for="middlename" value="{{ __('Middle Name') }}"/>
            <x-jet-input id="middlename" type="text" class="mt-1 block w-full" autocomplete="middlename" required wire:model.defer="middlename"/>
            <x-jet-input-error for="middlename" class="mt-2"/>
        </div>

        <!-- lname -->
        <div class="col-span-6">
            <x-jet-label for="lastname" value="{{ __('Last Name') }}" />
            <x-jet-input id="lastname" type="text" class="mt-1 block w-full" autocomplete="lastname" required wire:model.defer="lastname"/>
            <x-jet-input-error for="lastname" class="mt-2"/>
        </div>

        <!-- suffix -->
        <div class="col-span-6">
            <x-jet-label for="suffix" value="{{ __('Suffix (Optional)') }}" />
            <x-jet-input id="suffix" type="text" class="mt-1 block w-full" autocomplete="suffix" wire:model.defer="suffix"/>
            <x-jet-input-error for="suffix" class="mt-2"/>
        </div>

        <!-- relationship -->
        <div class="col-span-6">
            <x-jet-label for="relationship" value="{{ __('Relationship') }}"/>
            <x-jet-input id="relationship" type="text" class="mt-1 block w-full" autocomplete="relationship" required wire:model.defer="relationship"/>
            <x-jet-input-error for="relationship" class="mt-2"/>
        </div>

        <!-- address -->
        <div class="col-span-6">
            <x-jet-label for="address" value="{{ __('Home Address') }}" />
            <x-jet-input id="address" type="text" class="mt-1 block w-full" autocomplete="address" required wire:model.defer="address"/>
            <x-jet-input-error for="address" class="mt-2"/>
        </div>

        <!-- mobile_number -->
        <div class="col-span-6">
            <x-jet-label for="mobile_number" value="{{ __('Mobile Number') }}" />
            <x-jet-input id="mobile_number" type="text" class="mt-1 block w-full" autocomplete="mobile_number" required wire:model.defer="mobile_number"/>
            <x-jet-input-error for="mobile_number" class="mt-2"/>
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