<x-jet-form-section submit="updateGuardian">
    <x-slot name="title">
        {{ __('Guardian Details') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your guardian information.') }}
    </x-slot>

    <x-slot name="form">
        <!-- fullname -->
        <div class="col-span-6">
            <x-jet-label for="fullname" value="{{ __('Fullname') }}" />
            <x-jet-input id="fullname" type="text" class="mt-1 block w-full" autocomplete="fullname" wire:model.defer="fullname"/>
            <x-jet-input-error for="fullname" class="mt-2"/>
        </div>

        <!-- relationship -->
        <div class="col-span-6">
            <x-jet-label for="relationship" value="{{ __('Relationship') }}"/>
            <x-jet-input id="relationship" type="text" class="mt-1 block w-full" autocomplete="relationship" wire:model.defer="relationship"/>
            <x-jet-input-error for="relationship" class="mt-2"/>
        </div>

        <!-- address -->
        <div class="col-span-6">
            <x-jet-label for="address" value="{{ __('Home Address') }}" />
            <x-jet-input id="address" type="text" class="mt-1 block w-full" autocomplete="address" wire:model.defer="address"/>
            <x-jet-input-error for="address" class="mt-2"/>
        </div>

        <!-- mobile_number -->
        <div class="col-span-6">
            <x-jet-label for="mobile_number" value="{{ __('Mobile Number') }}" />
            <x-jet-input id="mobile_number" type="text" class="mt-1 block w-full" autocomplete="mobile_number" wire:model.defer="mobile_number"/>
            <x-jet-input-error for="mobile_number" class="mt-2"/>
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