<x-jet-dialog-modal wire:model="addingSubject">
    <x-slot name="title">
        {{ __('Prospectus Maintenance') }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-8">
                    <x-jet-label for="subject-id" value="{{ __('Subject') }}"/>
                    <select wire:model.defer="prospectusSubject.subject_id" name="subject-id" class="w-full mt-1 bg-white flex-1 p-2 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" autofocus required>
                        @forelse ($subjects as $subject)
                            @if ($loop->first)
                                <option value="" selected>-- choose a subject --</option>
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

                <livewire:partials.pre-requisite-dropdown :preRequisiteSubjects="$preRequisiteSubjects" :preRequisites="$preRequisites" key="{{ 'pre-requisite-dropdown-add-'.now() }}">

                <livewire:partials.co-requisite-dropdown :coRequisiteSubjects="$coRequisiteSubjects" :coRequisites="$coRequisites" key="{{ 'co-requisite-dropdown-add-'.now() }}">
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('addingSubject')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="save" wire:loading.attr="disabled">
            {{ __('Add') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
