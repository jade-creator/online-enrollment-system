<div class="space-y-4">
    <div>
        <div class="flex items-align justify-between">
            <h3 class="font-bold text-md">{{ __('Program')}}</h3>
            @if (filled($programId))
                <button wire:click.prevent="$toggle('confirmingTerm')" class="mb-2 pt-1 pr-3 focus:outline-none active:outline-none"><x-icons.view-icon/></button>
            @endif
        </div>
        <div class="relative w-full bg-white pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
            <select wire:model="programId" wire:loading.attr="disabled" id="program" class="w-full bg-white flex-1 px-0 py-1 tracking-wide focus:outline-none border-0 focus:ring focus:ring-white focus:ring-opacity-0">
                @forelse ($this->programs as $program)
                    @if ($loop->first)
                        <option value="" selected>All</option>
                    @endif
                    <option value="{{ $program->id }}">{{ $program->code }}</option>
                @empty
                    <option value="">No records</option>
                @endforelse
            </select>
        </div>
    </div>

    <!-- Export Seciotn/s Confirmation Modal -->
    <x-jet-dialog-modal wire:model="confirmingTerm" maxWidth="sm">
        <x-slot name="title">
            {{ __('Select a Level and Term') }}
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-8">
                @forelse ($prospectusCollection as $prospectus)
                    @if ($loop->odd)
                        <div class="mt-2 col-span-8 font-bold text-indigo-500">
                            {{ $prospectus->level->level }}
                        </div>
                    @endif
                    <div class="col-span-8 border-b border-gray-200 hover:bg-gray-200">
                        <input wire:model="prospectusId" wire:loading.attr="disabled" value="{{ $prospectus->id }}" name="prospectusId{{ $prospectus->id }}" id="prospectusId{{ $prospectus->id }}" type="radio" class="hidden">
                        <label for="prospectusId{{ $prospectus->id }}" class="block w-full px-2 py-4">{{ $prospectus->term->term }}</label>
                    </div>
                @empty
                    <p class="text-center">No records found.</p>
                @endforelse
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingTerm')" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
