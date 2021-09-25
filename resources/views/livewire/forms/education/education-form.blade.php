<x-jet-form-section submit="updateEducationInfo">
    <x-slot name="title">
        {{ __('Education') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your education information.') }}
    </x-slot>

    {{-- @can('update', $attended) --}}

        <x-slot name="form">
            <!-- type -->
            <div class="col-span-3">
                <x-jet-label for="selectedType" value="{{ __('School Type') }}" />
                <select wire:model="attended.school_type_id" wire:loading.attr="disabled" name="selectedType" id="selectedType" required>
                    <option value="" selected>Choose a Type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->type }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="attended.school_type_id" class="mt-2"/>
            </div>
            <!-- level -->
            <div class="col-span-3">
                <x-jet-label for="selectedLevel" value="{{ __('Year / Grade / Level') }}" />
                <select wire:model="attended.level_id" name="selectedLevel" id="selectedLevel" required>
                    <option value="" selected>Choose a Level</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->level }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="attended.level_id" class="mt-2"/>
            </div>
            <!-- name of school -->
            <div class="col-span-6">
                <x-jet-label for="name" value="{{ __('School Name') }}"/>
                <x-jet-input wire:model.defer="attended.name" id="name" type="text" autocomplete="name" required/>
                <x-jet-input-error for="attended.name" class="mt-2"/>
            </div>
            <!-- program -->
            <div class="col-span-6">
                <x-jet-label for="program" value="{{ __('Program / Track and Strand / Specialization (Optional)') }}" />
                <x-jet-input wire:model.defer="attended.program" id="program" type="text" autocomplete="program" required/>
                <x-jet-input-error for="attended.program" class="mt-2"/>
            </div>
            {{-- data of grad --}}
            <div class="col-span-3">
                <x-jet-label for="date_graduated" value="{{ __('Date Graduated') }}" />
                <x-jet-input wire:model.defer="attended.date_graduated" id="date_graduated" type="date" autocomplete="date_graduated" required/>
                <x-jet-input-error for="attended.date_graduated" class="mt-2"/>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3 text-green-500 font-bold" on="saved">
                {{ __('Saved successfuly!') }}
            </x-jet-action-message>

            <x-jet-button class="w-20 tracking-widest bg-indigo-700 hover:bg-indigo-800" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    {{-- @endcan --}}
</x-jet-form-section>
