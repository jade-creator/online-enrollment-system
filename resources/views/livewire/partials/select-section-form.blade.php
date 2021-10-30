<x-jet-dialog-modal wire:model="addingClasses" :closeBtn="true">
    <x-slot name="title">
        @if (empty($sectionId) && is_null($section) && filled($sections))
            <span>{{ __('Section List') }}</span>
        @else
            <span>{{ $section->name ?? 'N/A' }} {{ 'Class Schedule' }}</span>
        @endif
    </x-slot>

    <x-slot name="content">
        <div class="w-full">
            <form class="sidebar w-full max-h-96 overflow-x-hidden overflow-y-auto">
                @if (empty($sectionId))
                    @forelse ($sections as $section)
                        @if ($section->isFull)
                            <button class="w-full text-left cursor-not-allowed py-3 px-6 bg-gray-50 border-b focus:outline-none" disabled>
                                <span class="w-full block flex items-center justify-between">
                                    <span class="block text-lg font-semibold">{{ $section->name ?? 'N/A' }}</span>
                                    <span class="text-sm font-bold text-green-500 uppercase">full</span>
                                </span>

                                <span class="block text-xs py-2">
                                    <span class="font-semibold text-gray-500">Days: <span class="font-normal text-blue-500">
                                        @foreach ($section->days->unique() as $day)
                                            {{ $loop->first ? '' : ', '  }}
                                            {{ $day->abbrev ?? 'N/A' }}
                                        @endforeach
                                    </span></span>
                                </span>
                            </button>
                        @else
                            <button wire:click.prevent="$set('sectionId', {{$section->id}})" class="w-full text-left focus:outline-none py-3 px-6 hover:bg-gray-100 border-b">
                                <span class="w-full block flex items-center justify-between">
                                    <span class="block text-lg font-semibold">{{ $section->name ?? 'N/A' }}</span>
                                    <span class="text-sm font-bold text-gray-400">{{$section->registrations->count() ?? 'N/A'}} / {{$section->seat ?? 'N/A'}}</span>
                                </span>

                                <span class="block text-xs py-2">
                                    <span class="font-semibold text-gray-500">Days: <span class="font-normal text-blue-500">
                                            @foreach ($section->days->unique() as $day)
                                                {{ $loop->first ? '' : ', '  }}
                                                {{ $day->abbrev ?? 'N/A' }}
                                            @endforeach
                                        </span>
                                    </span>
                                </span>
                            </button>
                        @endif
                    @empty
                        <div class="w-full h-40">
                            <p class="w-full text-sm text-gray-500 text-center">No result found.</p>
                        </div>
                    @endforelse
                @endif

                <div class="col-span-8">
                    <div class="grid grid-cols-8 gap-2 col-span-8 py-2 text-left shadow-sm">
                        @foreach ($days as $day)
                            <div class="col-span-8 font-bold rounded-base px-6 py-2 sticky top-0 bg-white shadow-sm">
                                {{$day->name ?? 'N/A'}}
                            </div>

                            @foreach ($day->schedules as $schedule)
                                <div class="col-span-8 rounded-md p-2 px-6 flex items-center justify-between text-xs font-bold">
                                    <div class="w-1/2 md:w-4/6">
                                        <p class="truncate">{{$schedule->prospectusSubject->subject->code ?? 'N/A'}} - {{$schedule->prospectusSubject->subject->title ?? 'N/A'}}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="border border-gray-300 rounded-md p-2">{{\Carbon\Carbon::parse($schedule->start_time)->format('h:i a') ?? 'N/A'}}</div>
                                        <div class="lowercase px-2 text-gray-400">to</div>
                                        <div class="border border-gray-300 rounded-md p-2">{{\Carbon\Carbon::parse($schedule->end_time)->format('h:i a') ?? 'N/A'}}</div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
    </x-slot>

    @if (filled($sectionId) && $schedules->isNotEmpty())
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('sectionId', '')">
                {{ __('Back') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="saveSchedule" wire:loading.attr="disabled">
                {{ __('Apply Schedule') }}
            </x-jet-button>
        </x-slot>
    @endif
</x-jet-dialog-modal>
