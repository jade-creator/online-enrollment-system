<x-jet-form-section submit="updateContact">
    <x-slot name="title">
        {{ __('Contacts') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your contact information. Note: All fields are required.') }}
    </x-slot>

    <x-slot name="form">
        <!-- address -->
        <div class="col-span-6">
            <x-jet-label for="address" value="{{ __('Home Address') }}" />
            <x-jet-input id="address" type="text" class="mt-1 block w-full" autocomplete="address" required wire:model.defer="address"/>
            <x-jet-input-error for="address" class="mt-2"/>
        </div>

        <!-- mobile -->
        <div class="col-span-6">
            <x-jet-label for="mobile_number" value="{{ __('Mobile Number') }}"/>
            <x-jet-input id="mobile_number" type="text" class="mt-1 block w-full" autocomplete="mobile_number" required wire:model.defer="mobile_number"/>
            <x-jet-input-error for="mobile_number" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 text-green-500 font-bold" on="saved">
            {{ __('Saved successfuly!') }}
        </x-jet-action-message>

        <x-jet-button class="bg-indigo-700 hover:bg-indigo-800" wire:loading.attr="disabled">
            {{ __('Save contacts') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>