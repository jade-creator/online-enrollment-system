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
                    <select name="selectedType" id="selectedType" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required wire:model="attended.school_type_id" wire:loading.attr="disabled">
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
                <select name="selectedLevel" id="selectedLevel" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required wire:model="attended.level_id">
                    <option value="" selected>Choose a Level</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->level }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="attended.level_id" class="mt-2"/>
            </div>
            <!-- name of school -->
            <div class="col-span-6">
                <x-jet-label for="name" value="{{ __('School Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" autocomplete="name" required wire:model.defer="attended.name"/>
                <x-jet-input-error for="attended.name" class="mt-2"/>
            </div>
            <!-- program -->
            <div class="col-span-6">
                <x-jet-label for="program" value="{{ __('Program / Track and Strand / Specialization (Optional)') }}" />
                <x-jet-input id="program" type="text" class="mt-1 block w-full" autocomplete="program" required wire:model.defer="attended.program"/>
                <x-jet-input-error for="attended.program" class="mt-2"/>
            </div>
            {{-- data of grad --}}
            <div class="col-span-3">
                <x-jet-label for="date_graduated" value="{{ __('Date Graduated') }}" />
                <x-jet-input id="date_graduated" type="date" class="mt-1 block w-full" autocomplete="date_graduated" required wire:model.defer="attended.date_graduated"/>
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