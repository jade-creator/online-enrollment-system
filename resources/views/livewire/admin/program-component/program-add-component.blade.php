<x-jet-dialog-modal wire:model="addingProgram">
    <x-slot name="title">
        {{ __('Program Maintenance') }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="grid grid-cols-8 gap-6">
                <div class="col-span-8">
                    <div class="mt-4 grid grid-cols-8 gap-6">
                        <div class="col-span-4">
                            <x-jet-label for="code" value="{{ __('Code') }}" />
                            <x-jet-input wire:model.defer="program.code" id="code" class="block mt-1 w-full" type="text" name="code" autofocus required/>
                            <x-jet-input-error for="program.code" class="mt-2"/>
                        </div>

                        <div class="col-span-4">
                            <x-jet-label for="year" value="{{ __('No. of Years') }}" />
                            <x-jet-input wire:model.defer="program.year" id="year" class="block mt-1 w-full" type="number" name="year" autofocus required/>
                            <x-jet-input-error for="program.year" class="mt-2"/>
                        </div>
                    </div>

                    <div class="mt-4 col-span-8">
                        <x-jet-label for="program" value="{{ __('Program') }}" />
                        <x-jet-input wire:model.defer="program.program" id="program" class="block mt-1 w-full" type="text" name="program" autofocus required/>
                        <x-jet-input-error for="program.program" class="mt-2"/>
                    </div>

                    <div class="mt-4 col-span-8">
                        <x-jet-label for="description" value="{{ __('Description') }}" />
                        <textarea wire:model.defer="program.description" id="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="description" autofocus required></textarea>
                        <x-jet-input-error for="program.description" class="mt-2"/>
                    </div>
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('addingProgram')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="save" wire:loading.attr="disabled">
            {{ __('Add') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
