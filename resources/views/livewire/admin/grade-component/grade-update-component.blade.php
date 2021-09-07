<x-jet-dialog-modal wire:model="viewingGrade" maxWidth="sm">
    <x-slot name="title">
        {{ __("Student's Grade") }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="col-span-6 mb-2">
                <x-jet-label for="code" value="{{ __('Subject Code') }}" class="my-2" />
                <input wire:model="code" readonly type="text" id="code" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            </div>

            <div class="col-span-6">
                <x-jet-label for="grade" value="{{ __('Grade') }}" class="my-2"/>
                <input wire:model.defer="grade.value" type="number" id="grade" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-jet-input-error for="grade.value" class="mt-2"/>
            </div>
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
