<x-jet-form-section submit="updateOrCreateFullname">
    <x-slot name="title">
        {{ __('Fullname') }}
    </x-slot>

    <x-slot name="description">
        {{ __('') }}
    </x-slot>

    <x-slot name="form">
        <!-- fName -->
        <div class="col-span-6">
            <x-jet-label for="firstname" value="{{ __('First Name') }}" />
            <x-jet-input id="firstname" type="text" class="mt-1 block w-full" autocomplete="firstname" required wire:model.defer="person.firstname" wire:loading.attr="disabled"/>
            <x-jet-input-error for="person.firstname" class="mt-2"/>
        </div>

        <!-- mname -->
        <div class="col-span-6">
            <x-jet-label for="middlename" value="{{ __('Middle Name') }}"/>
            <x-jet-input id="middlename" type="text" class="mt-1 block w-full" autocomplete="middlename" required wire:model.defer="person.middlename" wire:loading.attr="disabled"/>
            <x-jet-input-error for="person.middlename" class="mt-2"/>
        </div>

        <!-- lname -->
        <div class="col-span-6">
            <x-jet-label for="lastname" value="{{ __('Last Name') }}" />
            <x-jet-input id="lastname" type="text" class="mt-1 block w-full" autocomplete="lastname" required wire:model.defer="person.lastname" wire:loading.attr="disabled"/>
            <x-jet-input-error for="person.lastname" class="mt-2"/>
        </div>

        <!-- suffix -->
        <div class="col-span-6">
            <x-jet-label for="suffix" value="{{ __('Suffix (Optional)') }}" />
            <x-jet-input id="suffix" type="text" class="mt-1 block w-full" autocomplete="suffix" wire:model.defer="person.suffix" wire:loading.attr="disabled"/>
            <p class="mt-3 text-xs text-gray-500 font-semibold">{{ __('"Suffix" is optional you can leave it blank if not applicable.')}}</p>
            <x-jet-input-error for="person.suffix" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 text-green-500 font-bold" on="saved">
            {{ __('Saved successfuly!') }}
        </x-jet-action-message>

        <x-jet-action-message class="mr-3 text-red-500 font-bold" on="error">
            {{ __('Failed! Please try again.') }}
        </x-jet-action-message>

        <x-jet-button class="bg-indigo-700 hover:bg-indigo-800" wire:loading.attr="disabled">
            {{ __('Save fullname') }}
        </x-jet-button>

        @include('partials.alerts')
    </x-slot>
</x-jet-form-section>