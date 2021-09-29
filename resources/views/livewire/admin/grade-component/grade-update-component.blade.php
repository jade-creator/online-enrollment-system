<x-jet-dialog-modal wire:model="viewingGrade" maxWidth="sm">
    <x-slot name="title">
        {{ __("Student's Grade") }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="col-span-6 mb-2">
                <x-jet-label for="code" value="{{ __('Subject Code') }}" class="my-2" />
                <input wire:model="code" readonly type="text" id="code">
            </div>

            <div class="col-span-6">
                <x-jet-label for="type" value="{{ __('Grade') }}" class="my-2"/>
                <select wire:model="type" wire:loading.attr="disabled" name="type">
                    <option value="">-- select a grade --</option>
                    <option value="scale">Scale</option>
                    <option value="Incomplete">Incomplete</option>
                    <option value="Dropped">Dropped</option>
                    <option value="TBA">TBA</option>
                </select>
                <x-jet-input-error for="type" class="mt-2"/>
            </div>

            @if ($type == 'scale')
                <div class="col-span-6">
                    <x-jet-label for="value" value="" class="my-2"/>
                    <input wire:model.defer="value" wire:loading.attr="disabled" type="number" id="value" name="value" step="0.01" min="1" max="100">
                    <x-jet-input-error for="value" class="mt-2"/>
                </div>
            @endif
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('viewingGrade')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="update" wire:loading.attr="disabled">
            {{ __('Submit') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
