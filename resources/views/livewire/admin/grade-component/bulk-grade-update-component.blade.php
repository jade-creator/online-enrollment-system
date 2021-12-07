<x-jet-dialog-modal wire:model="viewingBulkGrade" maxWidth="sm">
    <x-slot name="title">Grade</x-slot>

    <x-slot name="content">
        <form class="w-full px-6 mb-2">
            <div class="w-full">
                <x-jet-label for="prospectus_subject_id" value="{{ __('Subject') }}" class="my-2"/>
                <select wire:model.defer="prospectusSubjectId" wire:loading.attr="disabled" name="prospectus_subject_id" required>
                    <option value="">Select a subject</option>
                    @foreach ($section->prospectus->subjects as $prospectus_subject)
                        <option value="{{ $prospectus_subject->id }}">{{ $prospectus_subject->subject->code }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="prospectusSubjectId" class="mt-2"/>
            </div>

            <div class="w-full">
                <x-jet-label for="type" value="{{ __('Grade') }}" class="my-2"/>
                <select wire:model="type" wire:loading.attr="disabled" name="type">
                    <option value="">Select a grade</option>
                    <option value="scale">Scale</option>
                    <option value="Incomplete">Incomplete</option>
                    <option value="Dropped">Dropped</option>
                    <option value="TBA">TBA</option>
                </select>
                <x-jet-input-error for="type" class="mt-2"/>
            </div>

            @if ($type == 'scale')
                <div class="w-full">
                    <x-jet-label for="value" value="" class="my-2"/>
                    <input wire:model.defer="value" wire:loading.attr="disabled" type="number" id="value" name="value" step="0.01" min="1" max="100" placeholder="0 - 100">
                    <x-jet-input-error for="value" class="mt-2"/>
                </div>
            @endif
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('viewingBulkGrade')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="update" wire:loading.attr="disabled">
            {{ __('Submit') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
