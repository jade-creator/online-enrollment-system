<div class="w-full">
    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Student Maintenance"></x-table.title>

        <x-table.main>
            <x-slot name="filter"></x-slot>
            <x-slot name="paginationLink"></x-slot>
            <x-slot name="head"></x-slot>

            <x-slot name="body">
                <div class="grid place-items-center">
                    <x-jet-form-section submit="" class="w-11/12 md:w-3/4">
                        <x-slot name="title">
                            <div class="flex items-center">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <img class="border border-gray-200 mt-1 h-12 w-12 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="photo"/>
                                @endif
                                <p class="capitalize px-3">{{ $student->user->person->full_name ?? 'N/A' }}</p>
                            </div>
                        </x-slot>

                        <x-slot name="description">Please fill out the form with correct data.</x-slot>

                        <x-slot name="form">
                            <form>
                                <div class="col-span-6">
                                    <x-jet-label for="student_id" value="{{ __('Student ID') }}"/>
                                    <x-jet-input wire:model.defer="student.custom_id" id="student_id" type="text" name="student_id" autofocus autocomplete="student_id"/>
                                    <x-jet-input-error for="student.custom_id" class="mt-2"/>
                                </div>
                                <div class="col-span-6 md:col-span-3">
                                    <x-jet-label for="program_id" value="{{ __('Program') }}"/>
                                    <select wire:model="student.program_id" wire:loading.attr="disabled" id="program_id" name="program_id">
                                        @forelse ($this->programs as $program)
                                            @if ($loop->first) <option value="">Select a program</option>@endif

                                            <option value="{{ $program->id }}">{{ $program->program ?? 'N/A' }}</option>
                                        @empty
                                            <option value="">No records</option>
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="student.program_id" class="mt-2"/>
                                </div>
                                <div class="col-span-6 md:col-span-3">
                                    <x-jet-label for="curriculum_id" value="{{ __('Curriculum') }}"/>
                                    <select wire:model="student.curriculum_id" wire:loading.attr="disabled" id="curriculum_id" name="curriculum_id">
                                        @forelse ($curriculums as $curriculum)
                                            @if ($loop->first) <option value="">Select a curriculum</option> @endif

                                            <option value="{{ $curriculum->id }}">{{ $curriculum->code ?? 'N/A' }}</option>
                                        @empty
                                            <option value="">No records</option>
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="student.curriculum_id" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="student.isRegular" value="{{ __('Student Classification') }}" />
                                    <fieldset name="classification" class="w-100 flex items-center gap-6">
                                        <label for="regular" class="w-1/2 border border-gray-300 hover:border-indigo-400 rounded-md p-2 flex items-center cursor-pointer">
                                            <input wire:model.defer="student.isRegular" wire:loading.attr="disabled" id="regular" type="radio" value="1" name="classification" class="mr-2">
                                            <label for="regular" class="cursor-pointer text-gray-600">Regular</label>
                                        </label>
                                        <label for="irregular" class="w-1/2 border border-gray-300 hover:border-indigo-400 rounded-md p-2 flex items-center cursor-pointer">
                                            <input wire:model.defer="student.isRegular" wire:loading.attr="disabled" id="irregular" type="radio" value="0" name="classification" class="mr-2">
                                            <label for="irregular" class="cursor-pointer">Irregular</label>
                                        </label>
                                    </fieldset>
                                    <x-jet-input-error for="student.isRegular" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label for="student.isNew" value="{{ __('Student Type') }}" />
                                    <fieldset name="type" class="w-100 flex items-center gap-6">
                                        <label for="new" class="w-1/2 border border-gray-300 hover:border-indigo-400 rounded-md p-2 flex items-center cursor-pointer">
                                            <input wire:model.defer="student.isNew" wire:loading.attr="disabled" id="new" type="radio" value="1" name="type" class="mr-2">
                                            <label for="new" class="cursor-pointer">New</label>
                                        </label>
                                        <label for="old" class="w-1/2 border border-gray-300 hover:border-indigo-400 rounded-md p-2 flex items-center cursor-pointer">
                                            <input wire:model.defer="student.isNew" wire:loading.attr="disabled" id="old" type="radio" value="0" name="type" class="mr-2">
                                            <label for="old" class="cursor-pointer">Old</label>
                                        </label>
                                    </fieldset>
                                    <x-jet-input-error for="student.isNew" class="mt-2"/>
                                </div>
                            </form>
                        </x-slot>

                        <x-slot name="actions">
                            <x-jet-action-message class="mr-3 text-green-500 font-bold w-full" on="saved">
                                {{ __('Saved successfuly!') }}
                            </x-jet-action-message>

                            <x-jet-action-message class="mr-3 text-red-500 font-bold w-full" on="error">
                                {{ __('Failed! Please try again.') }}
                            </x-jet-action-message>

                            <a href="{{ route('users.students.index') }}">
                                <x-jet-secondary-button>
                                    {{ __('Cancel') }}
                                </x-jet-secondary-button>
                            </a>

                            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="update" wire:loading.attr="disabled">
                                {{ __('Update') }}
                            </x-jet-button>
                        </x-slot>
                    </x-jet-form-section>
                    <x-jet-section-border/>
                </div>
            </x-slot>
        </x-table.main>
    </div>
</div>
