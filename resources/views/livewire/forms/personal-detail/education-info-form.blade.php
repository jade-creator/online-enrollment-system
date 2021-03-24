<x-jet-form-section submit="updateEducationInfo">
    <x-slot name="title">
        {{ __('Education') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your education information.') }}
    </x-slot>

    <x-slot name="form">
        <!-- type -->
        <div class="col-span-3">
            <x-jet-label for="selectedType" value="{{ __('School Type') }}" />
                <select name="selectedType" id="selectedType" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required wire:model="selectedType" wire:loading.attr="disabled">
                    <option value="" selected>Choose a Type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->type }}</option>
                    @endforeach
                </select>
            <x-jet-input-error for="selectedType" class="mt-2"/>
        </div>
        <!-- level -->
        <div class="col-span-3">
            <x-jet-label for="selectedLevel" value="{{ __('Year / Grade / Level') }}" />
            <select name="selectedLevel" id="selectedLevel" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required wire:model="selectedLevel">
                <option value="" selected>Choose a Level</option>
                @foreach ($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->level }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="selectedLevel" class="mt-2"/>
        </div>
        <!-- name of school -->
        <div class="col-span-6">
            <x-jet-label for="school_name" value="{{ __('School Name') }}" />
            <x-jet-input id="school_name" type="text" class="mt-1 block w-full" autocomplete="school_name" required wire:model.defer="school_name"/>
            <x-jet-input-error for="school_name" class="mt-2"/>
        </div>
        <!-- program -->
        <div class="col-span-6">
            <x-jet-label for="prog_track_spec" value="{{ __('Program / Track and Strand / Specialization (Optional)') }}" />
            <x-jet-input id="prog_track_spec" type="text" class="mt-1 block w-full" autocomplete="prog_track_spec" required wire:model.defer="prog_track_spec"/>
            <x-jet-input-error for="prog_track_spec" class="mt-2"/>
        </div>
        {{-- data of grad --}}
        <div class="col-span-3">
            <x-jet-label for="date_of_grad" value="{{ __('Date Graduated') }}" />
            <x-jet-input id="date_of_grad" type="date" class="mt-1 block w-full" autocomplete="date_of_grad" required wire:model.defer="date_of_grad"/>
            <x-jet-input-error for="date_of_grad" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 p-2 text-green-500 font-bold" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>