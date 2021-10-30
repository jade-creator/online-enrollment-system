<x-jet-form-section submit="updateOrCreateFullname">
    <x-slot name="title">
        <span class="capitalize">{{ auth()->user()->role->name ?? 'N/A' }}</span>
    </x-slot>

    <x-slot name="description">
        {{ __('') }}
    </x-slot>

    <x-slot name="form">
        @if (auth()->user()->role->name != 'student')
            <div class="col-span-6">
                <x-jet-label for="salutation" value="{{ __('Salutation') }}" />
                <select wire:model.defer="employee.salutation" wire:loading.attr="disabled" id="salutation" name="salutation" required>
                    <option value="" selected>Select a salutation</option>
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

        <!-- fName -->
        <div class="col-span-6">
            <x-jet-label for="firstname" value="{{ __('First Name') }}" />
            <x-jet-input wire:model.defer="person.firstname" wire:loading.attr="disabled" id="firstname" type="text" class="mt-1 block w-full" autocomplete="firstname" required/>
            <x-jet-input-error for="person.firstname" class="mt-2"/>
        </div>

        <!-- mname -->
        <div class="col-span-6">
            <x-jet-label for="middlename" value="{{ __('Middle Name') }}"/>
            <x-jet-input wire:model.defer="person.middlename" wire:loading.attr="disabled" id="middlename" type="text" class="mt-1 block w-full" autocomplete="middlename" required/>
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
            <x-jet-input wire:model.defer="person.suffix" wire:loading.attr="disabled" id="suffix" type="text" class="mt-1 block w-full" autocomplete="suffix"/>
            <p class="mt-3 text-xs text-gray-500 font-semibold">{{ __('"Suffix" is optional you can leave it blank if not applicable.')}}</p>
            <x-jet-input-error for="person.suffix" class="mt-2"/>
        </div>

        @if (auth()->user()->role->name != 'student')
            <div class="col-span-6">
                <x-jet-label for="faculty_id" value="{{ __('Faculty') }}" />
                <select wire:model.defer="employee.faculty_id" wire:loading.attr="disabled" id="faculty_id" name="faculty_id" required>
                    <option value="" selected>Select a faculty</option>
                    @forelse($this->faculties as $faculty)
                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                    @empty
                    @endforelse
                </select>
                <x-jet-input-error for="employee.faculty_id" class="mt-2"/>
            </div>
        @else
            <div class="col-span-6">
                <x-jet-label for="program_id" value="{{ __('Program') }}" />
                <select wire:model.defer="student.program_id" wire:loading.attr="disabled" id="program_id" name="program_id" required>
                    <option value="" selected>Select a program</option>
                    @forelse($this->programs as $program)
                        <option value="{{ $program->id }}">{{ $program->program }}</option>
                    @empty
                    @endforelse
                </select>
                <x-jet-input-error for="student.program_id" class="mt-2"/>
            </div>
            <div class="col-span-6">
                <x-jet-label for="student.isRegular" value="{{ __('Student Classification') }}" />
                <fieldset name="classification" class="w-100 flex items-center gap-2">
                    <label for="regular" class="w-1/2 border border-gray-300 hover:border-indigo-400 rounded-md p-2 flex items-center cursor-pointer">
                        <input wire:model="student.isRegular" wire:loading.attr="disabled" id="regular" type="radio" value="1" name="classification" class="mr-2">
                        <label for="regular" class="cursor-pointer text-gray-600">Regular</label>
                    </label>
                    <label for="irregular" class="w-1/2 border border-gray-300 hover:border-indigo-400 rounded-md p-2 flex items-center cursor-pointer">
                        <input wire:model="student.isRegular" wire:loading.attr="disabled" id="irregular" type="radio" value="0" name="classification" class="mr-2">
                        <label for="irregular" class="cursor-pointer">Irregular</label>
                    </label>
                </fieldset>
                <x-jet-input-error for="student.isRegular" class="mt-2"/>
            </div>
            <div class="col-span-6">
                <x-jet-label for="student.isNew" value="{{ __('Student Type') }}" />
                <fieldset name="type" class="w-100 flex items-center gap-2">
                    <label for="new" class="w-1/2 border border-gray-300 hover:border-indigo-400 rounded-md p-2 flex items-center cursor-pointer">
                        <input wire:model="student.isNew" wire:loading.attr="disabled" id="new" type="radio" value="1" name="type" class="mr-2">
                        <label for="new" class="cursor-pointer">New</label>
                    </label>
                    <label for="old" class="w-1/2 border border-gray-300 hover:border-indigo-400 rounded-md p-2 flex items-center cursor-pointer">
                        <input wire:model="student.isNew" wire:loading.attr="disabled" id="old" type="radio" value="0" name="type" class="mr-2">
                        <label for="old" class="cursor-pointer">Old</label>
                    </label>
                </fieldset>
                <x-jet-input-error for="student.isNew" class="mt-2"/>
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
            {{ __('Save and Proceed') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
