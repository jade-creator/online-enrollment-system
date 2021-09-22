<x-jet-dialog-modal wire:model="addingClasses">
    <x-slot name="title">
        {{ __('Class Schedule') }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-8">
                    <x-jet-label for="sectionId" value="{{ __('Section') }}"/>
                    <select wire:model="sectionId" name="sectionId" autofocus required>
                        @forelse ($sections as $section)
                            @if ($loop->first)
                                <option value="" selected>-- choose a section --</option>
                            @endif
                            <option value="{{ $section->id ?? 'N/A' }}">{{ $section->name ?? 'N/A' }}</option>
                        @empty
                        @endforelse
                    </select>
                    <x-jet-input-error for="sectionId" class="mt-2"/>
                </div>

                <div class="mt-4 col-span-8">
                    <x-jet-label for="schedules" value="{{ __('Schedules') }}"/>
                    <div class="mb-4 grid grid-cols-8 gap-2 col-span-8">
                        <div class="col-span-2 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">subject code</div>
                        <div class="col-span-2 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">subject name</div>
                        <div class="col-span-1 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">day</div>
                        <div class="col-span-1 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">start time</div>
                        <div class="col-span-1 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">end time</div>
                        <div class="col-span-1 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">unit</div>
                    </div>

                    <div class="grid grid-cols-8 gap-2 col-span-8 border-b-2 border-gray-200 py-2">
                        @forelse ($schedules as $schedule)
                            <div class="col-span-2 text-left">{{ $schedule->prospectusSubject->subject->code ?? 'N/A' }}</div>
                            <div class="col-span-2 text-left">{{ $schedule->prospectusSubject->subject->title ?? 'N/A' }}</div>
                            <div class="col-span-1 text-left">{{ $schedule->day->name ?? 'N/A' }}</div>
                            <div class="col-span-1 text-left">{{ \Carbon\Carbon::parse($schedule->start_time)->format('g: ia') ?? 'N/A' }}</div>
                            <div class="col-span-1 text-left">{{ \Carbon\Carbon::parse($schedule->end_time)->format('g: ia') ?? 'N/A' }}</div>
                            <div class="col-span-1 text-left">{{ $schedule->prospectusSubject->unit ?? 'N/A' }}</div>
                        @empty
                            <x-table.no-result>No schedules found. Sorry! Unable to view schedule/s.🤔</x-table.no-result>
                        @endforelse
                    </div>
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('addingClasses')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="save" wire:loading.attr="disabled">
            {{ __('Apply Schedule') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>