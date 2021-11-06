<x-jet-dialog-modal wire:model="addingSchedule" :closeBtn="true">
    <x-slot name="title">
        @if (empty($employee))
            {{ __('Select a Professor') }}
        @else
            <span class="flex items-center">
                @if ( Laravel\Jetstream\Jetstream::managesProfilePhotos() )
                    <span class="hidden md:block mr-4 flex-shrink-0"><img class="h-8 w-8 rounded-full object-cover" src="{{ $employee['user']['profile_photo_url'] ?? 'N/A' }}"/></span>
                @endif
                <span class="block">{{ $employee['user']['person']['firstname'].' '.$employee['user']['person']['middlename'].' '.$employee['user']['person']['lastname']}}</span>
            </span>
        @endif
    </x-slot>

    <x-slot name="content">
        @if (empty($employee))
            <div x-show="open" class="w-full px-6 py-4">
                <input wire:model.debounce.1000ms="search" type="text" placeholder="Search" class="text-sm">
            </div>
        @endif

        <div class="w-full px-6 pt-2 mb-2">
            <form class="sidebar w-full max-h-72 overflow-x-hidden overflow-y-auto">
                <div wire:loading wire:target="search" class="w-full">
                    <div class="w-full h-40 text-blue-500 grid place-items-center">
                        <x-icons.loading-icon color="blue"/>
                    </div>
                </div>

                <div x-data="{ open: {{empty($employee) ? 'true' : 'false'}} }" wire:loading.class="hidden" wire:target="search" class="w-full">
                    <div x-show="open">
                        @forelse ($professors as $professor)
                            <button @click="open = !open" @click.stop wire:click.prevent="$set('employee', {{$professor}})" class="w-full flex items-center justify-between px-2 py-3 hover:bg-gray-50 rounded-md focus:outline-none">
                                <span class="flex items-center">
                                    @if ( Laravel\Jetstream\Jetstream::managesProfilePhotos() )
                                        <span class="hidden md:block mr-4 flex-shrink-0"><img class="h-8 w-8 rounded-full object-cover" src="{{ $professor->user->profile_photo_url ?? 'N/A' }}"/></span>
                                    @endif
                                    <span class="font-semibold block text-left">
                                        <span class="block">{{ $professor->user->person->full_name ?? 'N/A'}}</span>
                                        <span class="block text-xs font-bold">Employee ID: <span class="text-gray-500">{{ $professor->custom_id ?? 'N/A' }}</span></span>
                                    </span>
                                </span>

                                <span class="text-gray-400"><x-icons.right-arrow-icon/></span>
                            </button>
                        @empty
                            <div class="w-full h-40">
                                <p class="w-full text-sm text-gray-500 text-center">No result found.</p>
                            </div>
                        @endforelse
                    </div>
                    <div x-show="! open">
                        <div class="w-full grid grid-cols-6 gap-2">
                            <div class="col-span-6 mt-4">
                                <x-jet-label for="subject" value="{{ __('Subject') }}"/>
                                <select wire:model.defer="schedule.prospectus_subject_id" name="subject" autofocus required class="mt-2">
                                    @forelse ($prospectusSubjects as $prospectus_subject)
                                        @if ($loop->first)
                                            <option value="" selected>Select a subject</option>
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
                                            <option value="" selected>Select a day</option>
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
                                <select wire:model.defer="schedule.start_time" name="start_time" autofocus required class="mt-2">
                                    @forelse ($this->timeRanges as $time)
                                        @if ($loop->first)
                                            <option value="" selected>Select a start time</option>
                                        @endif
                                        <option value="{{ \Carbon\Carbon::parse($time)->format('H:i:s') ?? 'N/A' }}">{{ \Carbon\Carbon::parse($time)->format('h:i A') ?? 'N/A' }}</option>
                                    @empty
                                        <option value="">No records</option>
                                    @endforelse
                                </select>
                                <x-jet-input-error for="schedule.start_time" class="mt-2"/>
                            </div>

                            <div class="col-span-3 mt-4">
                                <x-jet-label for="end_time" value="{{ __('End Time') }}" />
                                <select wire:model.defer="schedule.end_time" name="end_time" autofocus required class="mt-2">
                                    @forelse ($this->timeRanges as $time)
                                        @if ($loop->first)
                                            <option value="" selected>Select an end time</option>
                                        @endif
                                        <option value="{{ \Carbon\Carbon::parse($time)->format('H:i:s') ?? 'N/A' }}">{{ \Carbon\Carbon::parse($time)->format('h:i A') ?? 'N/A' }}</option>
                                    @empty
                                        <option value="">No records</option>
                                    @endforelse
                                </select>
                                <x-jet-input-error for="schedule.end_time" class="mt-2"/>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </x-slot>

    @if (filled($employee))
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('employee', [])">
                {{ __('Back') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="save" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    @endif
</x-jet-dialog-modal>
