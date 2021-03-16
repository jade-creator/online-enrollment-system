<x-jet-form-section submit="updateOtherInfo">
    <x-slot name="title">
        {{ __('Other Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update other personal information.') }}
    </x-slot>

    <x-slot name="form">
        <!-- gender -->
        <div class="col-span-3">
            <x-jet-label for="gender" value="{{ __('Gender') }}" />
            <select name="gender" id="gender" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model.defer="gender" wire:loading.attr="disabled">
                <option value="Other">Other</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Prefer not to say">Prefer not to say</option>
            </select>
            <x-jet-input-error for="gender" class="mt-2"/>
        </div>

        <div class="col-span-3">
            <x-jet-label for="civil_status" value="{{ __('Civil Status') }}" />
            <select name="civil_status" id="civil_status" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model.defer="civil_status">
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Divorced">Divorced</option>
                <option value="Widowed">Widowed</option>
                <option value="Prefer not to say">Prefer not to say</option>
            </select>
            <x-jet-input-error for="civil_status" class="mt-2"/>
        </div>

        <div class="col-span-3">
            <x-jet-label for="religion" value="{{ __('Religion') }}" />
            <select name="religion" id="religion" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model.defer="religion">
                <option value="Other">Other</option>
                <option value="Catholic Christianity">Catholic Christianity</option>
                <option value="Protestant Christianity">Protestant Christianity</option>
                <option value="Islam">Islam</option>
                <option value="Tribal">Tribal</option>
                <option value="None">None</option>
            </select>
            <x-jet-input-error for="religion" class="mt-2"/>
        </div>

        <div class="col-span-3">
            <x-jet-label for="nationality" value="{{ __('Nationality') }}" />
            <x-jet-input id="nationality" type="text" class="mt-1 block w-full" autocomplete="nationality" wire:model.defer="nationality"/>
            <x-jet-input-error for="nationality" class="mt-2"/>
        </div>

        <div class="col-span-3">
            <x-jet-label for="birthdate" value="{{ __('Birthdate') }}" />
            <x-jet-input id="birthdate" type="date" class="mt-1 block w-full" autocomplete="birthdate" wire:model.defer="birthdate"/>
            <x-jet-input-error for="birthdate" class="mt-2"/>
        </div>

        <div class="col-span-3">
            <x-jet-label for="birthplace" value="{{ __('Birthplace') }}" />
            <x-jet-input id="birthplace" type="text" class="mt-1 block w-full" autocomplete="birthplace" wire:model.defer="birthplace"/>
            <x-jet-input-error for="birthplace" class="mt-2"/>
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