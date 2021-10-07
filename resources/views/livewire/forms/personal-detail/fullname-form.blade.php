<x-jet-form-section submit="updateOrCreateFullname">
    <x-slot name="title">
        {{ __('Fullname') }}
    </x-slot>

    <x-slot name="description">
        {{ __('') }}
    </x-slot>

    <x-slot name="form">
        @if (auth()->user()->role->name != 'student')
            <div class="col-span-6">
                <x-jet-label for="salutation" value="{{ __('Salutation') }}" />
                <select wire:model.defer="employee.salutation" wire:loading.attr="disabled" id="salutation" name="salutation" required>
                    <option value="" selected>-- select a salutation --</option>
                    <option value="Mr.">Mr.</option>
                    <option value="Mrs.">Mrs.</option>
                    <option value="Prof.">Prof.</option>
                    <option value="Sir">Sir</option>
                    <option value="Ms.">Ms.</option>
                    <option value="Miss">Miss</option>
                    <option value="Madam">Madam</option>
                    <option value="Madame">Madame</option>
                    <option value="Ma'am">Ma'am</option>
                </select>
                <x-jet-input-error for="employee.salutation" class="mt-2"/>
            </div>
        @endif

        <div class="col-span-6">
            <x-jet-label for="firstname" value="{{ __('First Name') }}" />
            <x-jet-input wire:model.defer="person.firstname" wire:loading.attr="disabled" id="firstname" type="text" class="mt-1 block w-full" autocomplete="firstname" required/>
            <x-jet-input-error for="person.firstname" class="mt-2"/>
        </div>

        <div class="col-span-6">
            <x-jet-label for="middlename" value="{{ __('Middle Name') }}"/>
            <x-jet-input wire:model.defer="person.middlename" wire:loading.attr="disabled" id="middlename" type="text" class="mt-1 block w-full" autocomplete="middlename" required/>
            <x-jet-input-error for="person.middlename" class="mt-2"/>
        </div>

        <div class="col-span-6">
            <x-jet-label for="lastname" value="{{ __('Last Name') }}" />
            <x-jet-input wire:model.defer="person.lastname" wire:loading.attr="disabled" id="lastname" type="text" class="mt-1 block w-full" autocomplete="lastname" required/>
            <x-jet-input-error for="person.lastname" class="mt-2"/>
        </div>

        <div class="col-span-6">
            <x-jet-label for="suffix" value="{{ __('Suffix (Optional)') }}" />
            <x-jet-input wire:model.defer="person.suffix" wire:loading.attr="disabled" id="suffix" type="text" class="mt-1 block w-full" autocomplete="suffix"/>
            <p class="mt-3 text-xs text-gray-500 font-semibold">{{ __('"Suffix" is optional you can leave it blank if not applicable.')}}</p>
            <x-jet-input-error for="person.suffix" class="mt-2"/>
        </div>

        @if (auth()->user()->role->name != 'student')
            <div class="col-span-6">
                <x-jet-label for="faculty_id" value="{{ __('Faculty') }}" />
                <select wire:model.defer="employee.faculty_id" wire:loading.attr="disabled" id="faculty_id" name="faculty_id" required>
                    <option value="" selected>-- select a faculty --</option>
                    @forelse($this->faculties as $faculty)
                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                    @empty
                    @endforelse
                </select>
                <x-jet-input-error for="employee.faculty_id" class="mt-2"/>
            </div>
        @endif
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
    </x-slot>
</x-jet-form-section>
