<x-jet-dialog-modal wire:model="addingSubject">
    <x-slot name="title">
        {{ __('Subject Maintenance') }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="grid grid-cols-8 gap-6">
                <div class="mt-3 col-span-8">
                    <div class="mt-4">
                        <x-jet-label for="subject-code" value="{{ __('Code') }}" />
                        <x-jet-input wire:model.defer="subject.code" id="subject-code" class="block mt-1 w-full" type="text" name="subject-code" autofocus required/>
                        <x-jet-input-error for="subject.code" class="mt-2"/>
                    </div>
                    <div class="mt-4">
                        <x-jet-label for="subject-title" value="{{ __('Title') }}" />
                        <x-jet-input wire:model.defer="subject.title" id="subject-title" class="block mt-1 w-full" type="text" name="subject-title" autofocus required/>
                        <x-jet-input-error for="subject.title" class="mt-2"/>
                    </div>
                    <div class="mt-4">
                        <x-jet-label for="subject-description" value="{{ __('Description') }}" />
                        <textarea wire:model.defer="subject.description" id="subject-description" class="block mt-1 w-full" name="subject-description" autofocus required></textarea>
                        <x-jet-input-error for="subject.description" class="mt-2"/>
                    </div>
                </div>
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
