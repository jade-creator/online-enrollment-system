<x-jet-form-section submit="updateOrCreateGuardian">
    <x-slot name="title">
        {{ __('Guardian Details') }}
    </x-slot>

    <x-slot name="description">
        {{ __('') }}
    </x-slot>

    {{-- @cannot('update', $guardian) --}}

        <x-slot name="form">
            <!-- fName -->
            <div class="col-span-6">
                <x-jet-label for="firstname" value="{{ __('First Name') }}" />
                <x-jet-input wire:model.defer="person.firstname" wire:loading.attr="disabled" id="firstname" type="text" autocomplete="firstname" required/>
                <x-jet-input-error for="person.firstname" class="mt-2"/>
            </div>

            <!-- mname -->
            <div class="col-span-6">
                <x-jet-label for="middlename" value="{{ __('Middle Name') }}"/>
                <x-jet-input wire:model.defer="person.middlename" wire:loading.attr="disabled" id="middlename" type="text"  autocomplete="middlename" required/>
                <x-jet-input-error for="person.middlename" class="mt-2"/>
            </div>

            <!-- lname -->
            <div class="col-span-6">
                <x-jet-label for="lastname" value="{{ __('Last Name') }}" />
                <x-jet-input wire:model.defer="person.lastname" wire:loading.attr="disabled" id="lastname" type="text" class="mt-1 block w-full" autocomplete="lastname" required/>
                <x-jet-input-error for="person.lastname" class="mt-2"/>
            </div>

            <!-- suffix -->
            <div class="col-span-6">
                <x-jet-label for="suffix" value="{{ __('Suffix (Optional)') }}" />
                <x-jet-input wire:model.defer="person.suffix" wire:loading.attr="disabled" id="suffix" type="text" autocomplete="suffix"/>
                <x-jet-input-error for="person.suffix" class="mt-2"/>
            </div>

            <!-- relationship -->
            <div class="col-span-6">
                <x-jet-label for="relationship" value="{{ __('Relationship') }}"/>
                <x-jet-input wire:model.defer="guardian.relationship" wire:loading.attr="disabled" id="relationship" type="text" autocomplete="relationship" required/>
                <x-jet-input-error for="guardian.relationship" class="mt-2"/>
            </div>

            <!-- address -->
            <div class="col-span-6">
                <x-jet-label for="address" value="{{ __('Home Address') }}" />
                <x-jet-input wire:model.defer="contact.address" wire:loading.attr="disabled" id="address" type="text" autocomplete="address" required/>
                <x-jet-input-error for="contact.address" class="mt-2"/>
            </div>

            <!-- mobile_number -->
            <div class="col-span-6">
                <x-jet-label for="mobile_number" value="{{ __('Mobile Number') }}" />
                <x-jet-input wire:model.defer="contact.mobile_number" wire:loading.attr="disabled" id="mobile_number" type="text" autocomplete="mobile_number" required/>
                <x-jet-input-error for="contact.mobile_number" class="mt-2"/>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3 text-green-500 font-bold" on="saved">
                {{ __('Saved successfuly!') }}
            </x-jet-action-message>

            <x-jet-action-message class="mr-3 text-red-500 font-bold" on="error">
                {{ __('Failed! Please try again.') }}
            </x-jet-action-message>

            <x-jet-button class="w-20 tracking-widest bg-indigo-700 hover:bg-indigo-800" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    {{-- @endcannot --}}
</x-jet-form-section>
