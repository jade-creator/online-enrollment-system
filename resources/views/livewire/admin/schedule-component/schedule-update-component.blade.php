<x-jet-dialog-modal wire:model="viewingSchedule">
    <x-slot name="title">
        @if (empty($employee))
            {{ __('Schedule Maintenance') }}
        @else
            <span class="flex items-center">
                @if ( Laravel\Jetstream\Jetstream::managesProfilePhotos() )
                    <span class="hidden md:block mr-4 flex-shrink-0"><img class="h-8 w-8 rounded-full object-cover" src="{{ $employee->user->profile_photo_url ?? 'N/A' }}"/></span>
                @endif
                <span class="block">{{ $employee->user->person->short_full_name ?? 'N/A'}}</span>
            </span>
        @endif
    </x-slot>

    <x-slot name="content">
        <div class="w-full px-6 pt-2 mb-2">
            <form class="sidebar w-full max-h-72 overflow-x-hidden overflow-y-auto">
            @if (empty($employee))
                <div class="w-full h-40">
                    <p class="w-full text-sm text-gray-500 text-center">No result found.</p>
                </div>
            @else
                <div class="w-full grid grid-cols-6 gap-2">
                    <div class="col-span-6 mt-4">
                        <x-jet-label for="subject" value="{{ __('Subject') }}"/>
                        <select wire:model.defer="schedule.prospectus_subject_id" name="subject" autofocus required class="mt-2">
                            @forelse ($prospectusSubjects as $prospectus_subject)
                                @if ($loop->first)
                                    <option value="">Select a subject</option>
                                @endif
                                <option value="{{ $prospectus_subject->id ?? 'N/A' }}">{{ $prospectus_subject->subject->title ?? 'N/A' }}</option>
                            @empty
                                <option value="">No added subject yet.</option>
                            @endforelse
                        </select>
                        <x-jet-input-error for="schedule.prospectus_subject_id" class="mt-2"/>
                    </div>

                    <div class="col-span-6 mt-4">
                        <x-jet-label for="day" value="{{ __('Day') }}" />
                        <select wire:model.defer="schedule.day_id" name="day" autofocus required class="mt-2">
                            @forelse ($days as $day)
                                @if ($loop->first)
                                    <option value="">Select a day</option>
                                @endif
                                <option value="{{ $day->id ?? 'N/A' }}">{{ $day->name ?? 'N/A' }}</option>
                            @empty
                                <option value="">No records</option>
                            @endforelse
                        </select>
                        <x-jet-input-error for="schedule.day_id" class="mt-2"/>
                    </div>

                    <div class="col-span-3 mt-4">
                        <x-jet-label for="start_time" value="{{ __('Start Time') }}" />
                        <x-jet-input wire:model.defer="schedule.start_time" id="start_time" class="block mt-1 w-full" type="time" autofocus required class="mt-2"/>
                        <x-jet-input-error for="schedule.start_time" class="mt-2"/>
                    </div>

                    <div class="col-span-3 mt-4">
                        <x-jet-label for="end_time" value="{{ __('End Time') }}" />
                        <x-jet-input wire:model.defer="schedule.end_time" id="end_time" class="block mt-1 w-full" type="time" autofocus required class="mt-2"/>
                        <x-jet-input-error for="schedule.end_time" class="mt-2"/>
                    </div>
                </div>
            @endif
            {{--            <div class="grid grid-cols-8 gap-6">--}}
{{--                <div class="mt-4 col-span-4">--}}
{{--                    <x-jet-label for="employee_id" value="{{ __('Employee ID') }}" />--}}
{{--                    <select wire:model="schedule.employee_id" wire:loading.attr="disabled" name="employee_id" autofocus required>--}}
{{--                        @forelse ($professors as $professor)--}}
{{--                            @if ($loop->first)--}}
{{--                                <option value="" selected>-- choose a professor --</option>--}}
{{--                            @endif--}}
{{--                            <option value="{{ $professor->custom_id ?? 'N/A' }}">{{ $professor->custom_id ?? 'N/A' }}</option>--}}
{{--                        @empty--}}
{{--                            <option value="">No added professor yet.</option>--}}
{{--                        @endforelse--}}
{{--                    </select>--}}
{{--                    <x-jet-input-error for="schedule.employee_id" class="mt-2"/>--}}
{{--                </div>--}}
{{--                <div class="mt-4 col-span-4">--}}
{{--                    <x-jet-label for="full_name" value="{{ __('Full Name') }}" />--}}
{{--                    <select wire:model="schedule.employee_id" wire:loading.attr="disabled" name="full_name" autofocus required>--}}
{{--                        @forelse ($professors as $professor)--}}
{{--                            @if ($loop->first)--}}
{{--                                <option value="" selected>-- choose a professor --</option>--}}
{{--                            @endif--}}
{{--                            <option value="{{ $professor->custom_id ?? 'N/A' }}">{{ $professor->salutation.' '.$professor->user->person->full_name ?? 'N/A' }}</option>--}}
{{--                        @empty--}}
{{--                            <option value="">No added professor yet.</option>--}}
{{--                        @endforelse--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--                <div class="mt-4 col-span-4">--}}
{{--                    <x-jet-label for="subject" value="{{ __('Subject') }}" />--}}
{{--                    <select wire:model.defer="schedule.prospectus_subject_id" name="subject" class="w-full mt-1 bg-white flex-1 p-2 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" autofocus required>--}}
{{--                        @forelse ($prospectusSubjects as $prospectus_subject)--}}
{{--                            @if ($loop->first)--}}
{{--                                <option value="" selected>-- choose a subject --</option>--}}
{{--                            @endif--}}
{{--                            <option value="{{ $prospectus_subject->id ?? 'N/A' }}">{{ $prospectus_subject->subject->title ?? 'N/A' }}</option>--}}
{{--                        @empty--}}
{{--                            <option value="">No records</option>--}}
{{--                        @endforelse--}}
{{--                    </select>--}}
{{--                    <x-jet-input-error for="schedule.prospectus_subject_id" class="mt-2"/>--}}
{{--                </div>--}}
{{--                <div class="mt-4 col-span-4">--}}
{{--                    <x-jet-label for="day" value="{{ __('Day') }}" />--}}
{{--                    <select wire:model="schedule.day_id" name="day" class="w-full mt-1 bg-white flex-1 p-2 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" autofocus required>--}}
{{--                        @forelse ($days as $day)--}}
{{--                            @if ($loop->first)--}}
{{--                                <option value="" selected>-- choose a day --</option>--}}
{{--                            @endif--}}
{{--                            <option value="{{ $day->id ?? 'N/A' }}">{{ $day->name ?? 'N/A' }}</option>--}}
{{--                        @empty--}}
{{--                            <option value="">No records</option>--}}
{{--                        @endforelse--}}
{{--                    </select>--}}
{{--                    <x-jet-input-error for="schedule.day_id" class="mt-2"/>--}}
{{--                </div>--}}
{{--                <div class="mt-4 col-span-4">--}}
{{--                    <x-jet-label for="start_time" value="{{ __('Start Time') }}" />--}}
{{--                    <x-jet-input wire:model.defer="schedule.start_time" id="start_time" class="block mt-1 w-full" type="time" autofocus required/>--}}
{{--                    <x-jet-input-error for="schedule.start_time" class="mt-2"/>--}}
{{--                </div>--}}
{{--                <div class="mt-4 col-span-4">--}}
{{--                    <x-jet-label for="end_time" value="{{ __('End Time') }}" />--}}
{{--                    <x-jet-input wire:model.defer="schedule.end_time" id="end_time" class="block mt-1 w-full" type="time" autofocus required/>--}}
{{--                    <x-jet-input-error for="schedule.end_time" class="mt-2"/>--}}
{{--                </div>--}}
{{--            </div>--}}
        </form>
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('viewingSchedule')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="update" wire:loading.attr="disabled">
            {{ __('Update') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
