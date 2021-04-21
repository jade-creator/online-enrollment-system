<x-jet-form-section submit="updateOtherInfo">
    <x-slot name="title">
        {{ __('Other Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update other personal information. Note: All fields are required.') }}
    </x-slot>

    <x-slot name="form">
        <!-- gender -->
        <div class="col-span-3">
            <x-jet-label for="gender" value="{{ __('Gender') }}" />
            <select name="gender" id="gender" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required wire:model.defer="detail.gender" wire:loading.attr="disabled">
                <option value="">Choose a gender</option>
                <option value="Other">Other</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Prefer not to say">Prefer not to say</option>
            </select>
            <x-jet-input-error for="detail.gender" class="mt-2"/>
        </div>

        <div class="col-span-3">
            <x-jet-label for="civil_status" value="{{ __('Civil Status') }}" />
            <select name="civil_status" id="civil_status" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required wire:model.defer="detail.civil_status" wire:loading.attr="disabled">
                <option value="">Choose a civil status</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Divorced">Divorced</option>
                <option value="Widowed">Widowed</option>
                <option value="Prefer not to say">Prefer not to say</option>
            </select>
            <x-jet-input-error for="detail.civil_status" class="mt-2"/>
        </div>

        <div class="col-span-3">
            <x-jet-label for="religion" value="{{ __('Religion') }}" />
            <select name="religion" id="religion" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required wire:model.defer="detail.religion" wire:loading.attr="disabled">
                <option value="">Choose a religion</option>
                <option value="Other">Other</option>
                <option value="Catholic Christianity">Catholic Christianity</option>
                <option value="Protestant Christianity">Protestant Christianity</option>
                <option value="Islam">Islam</option>
                <option value="Tribal">Tribal</option>
                <option value="None">None</option>
            </select>
            <x-jet-input-error for="detail.religion" class="mt-2"/>
        </div>

        <div class="col-span-3">
            <x-jet-label for="nationality" value="{{ __('Country of Citizenship') }}" />
            <select name="nationality" id="nationality" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required wire:model.defer="detail.country_id" wire:loading.attr="disabled">
                @foreach ($countries as $country)
                    <option value="{{$country->id}}">{{$country->name}}</option>
                @endforeach
            </select>
            <x-jet-input-error for="detail.country_id" class="mt-2"/>
        </div>

        <div class="col-span-3">
            <x-jet-label for="birthdate" value="{{ __('Birthdate') }}" />
            <x-jet-input id="birthdate" type="date" class="mt-1 block w-full" autocomplete="birthdate" required wire:model.defer="detail.birthdate" wire:loading.attr="disabled"/>
            <x-jet-input-error for="detail.birthdate" class="mt-2"/>
        </div>

        <div class="col-span-3">
            <x-jet-label for="birthplace" value="{{ __('Birthplace') }}" />
            <x-jet-input id="birthplace" type="text" class="mt-1 block w-full" autocomplete="birthplace" required wire:model.defer="detail.birthplace" wire:loading.attr="disabled"/>
            <x-jet-input-error for="detail.birthplace" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 text-green-500 font-bold" on="saved">
            {{ __('Saved successfuly!') }}
        </x-jet-action-message>

        <x-jet-button class="bg-indigo-700 hover:bg-indigo-800" wire:loading.attr="disabled">
            {{ __('Save Info') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>