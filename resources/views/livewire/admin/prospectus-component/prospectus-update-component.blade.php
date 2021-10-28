<x-jet-dialog-modal wire:model="viewingSubject">
    <x-slot name="title">
        {{ __('Prospectus Maintenance') }}
    </x-slot>

    <x-slot name="content">
        <form class="sidebar w-full px-6 mb-2 max-h-96 overflow-x-hidden overflow-y-auto">
            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-8">
                    <x-jet-label for="subject-id" value="{{ __('Subject') }}"/>
                    <select wire:model.defer="prospectusSubject.subject_id" name="subject-id" class="w-full mt-1 bg-white flex-1 p-2 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" autofocus required>
                        @forelse ($subjects as $subject)
                            @if ($loop->first)
                                <option value="{{ $prospectusSubject->subject_id ?? '' }}">{{ $prospectusSubject->subject->title ?? 'N/A' }}</option>
                            @endif
                            <option value="{{ $subject->id ?? 'N/A' }}">{{ $subject->title ?? 'N/A' }}</option>
                        @empty
                            <option value="">No records</option>
                        @endforelse
                    </select>
                    <x-jet-input-error for="prospectusSubject.subject_id" class="mt-2"/>
                </div>

                <div class="mt-4 col-span-8">
                    <x-jet-label for="subject-unit" value="{{ __('Unit') }}"/>
                    <x-jet-input wire:model.defer="prospectusSubject.unit" id="subject-unit" class="block mt-1 w-full" type="number" name="subject-title" autofocus required/>
                    <x-jet-input-error for="prospectusSubject.unit" class="mt-2"/>
                </div>

                <div class="mt-4 col-span-8">
                    <x-jet-label for="subject-computed" value="{{ __('Computed') }}"/>
                    <div class="flex items-center mt-2">
                        <input wire:model="prospectusSubject.isComputed" wire:loading.attr="disabled" type="checkbox" class="mx-1">
                        <span class="flex items-center">
                            @if ($prospectusSubject->isComputed)
                                <div class="mx-2 font-bold rounded-full bg-green-400 flex items-center justify-center" style="height: 8px; width: 8px; font-size: 5px;">&nbsp;</div>
                            @else
                                <div class="mx-2 font-bold rounded-full bg-red-400 flex items-center justify-center" style="height: 8px; width: 8px; font-size: 5px;">&nbsp;</div>
                            @endif
                            <p class="text-sm text-gray-500">Include to Cumulative Weighted Average (CWA) computation.</p>
                        </span>
                    </div>
                </div>

                <livewire:partials.pre-requisite-dropdown :preRequisiteSubjects="$preRequisiteSubjects" :preRequisites="$preRequisites" key="{{ 'pre-requisite-dropdown-update-'.now() }}">

                <livewire:partials.co-requisite-dropdown :coRequisiteSubjects="$coRequisiteSubjects" :coRequisites="$coRequisites" key="{{ 'co-requisite-dropdown-add-'.now() }}">
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('viewingSubject')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="update" wire:loading.attr="disabled">
            {{ __('Update') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
