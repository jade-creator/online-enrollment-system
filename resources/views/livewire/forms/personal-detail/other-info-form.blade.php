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
            <select  wire:model.defer="detail.gender" wire:loading.attr="disabled" name="gender" id="gender" class="truncate pr-5" required>
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
            <select wire:model.defer="detail.civil_status" wire:loading.attr="disabled" name="civil_status" id="civil_status" class="truncate pr-5" required>
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
            <select wire:model.defer="detail.religion" wire:loading.attr="disabled" name="religion" id="religion" class="truncate pr-5" required>
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
            <x-jet-label for="nationality" value="{{ __('Citizenship') }}" />
            <select wire:model.defer="detail.country_id" wire:loading.attr="disabled" name="nationality" id="nationality" class="truncate pr-5" required>
                <option value="" selected>Select nationality</option>
                @forelse ($countries as $country)
                    <option value="{{$country->id}}">{{$country->name}}</option>
                @empty
                    <option value="">No records</option>
                @endforelse
            </select>
            <x-jet-input-error for="detail.country_id" class="mt-2"/>
        </div>

        <div class="col-span-3">
            <x-jet-label for="birthdate" value="{{ __('Birthdate') }}" />
            <x-jet-input wire:model.defer="detail.birthdate" wire:loading.attr="disabled" id="birthdate" type="date" autocomplete="birthdate" required/>
            <x-jet-input-error for="detail.birthdate" class="mt-2"/>
        </div>

        <div class="col-span-3">
            <x-jet-label for="birthplace" value="{{ __('Birthplace') }}" />
            <x-jet-input wire:model.defer="detail.birthplace" wire:loading.attr="disabled" id="birthplace" type="text" autocomplete="birthplace" required/>
            <x-jet-input-error for="detail.birthplace" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 text-green-500 font-bold" on="saved">
            {{ __('Saved successfuly!') }}
        </x-jet-action-message>

        <x-jet-button class="bg-indigo-700 hover:bg-indigo-800" wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
