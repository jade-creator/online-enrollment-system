<x-jet-dialog-modal wire:model="addingPayment" maxWidth="sm">
    <x-slot name="title">
        {{ __('Payment Maintenance') }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-8">
                    <x-jet-label for="registration_id" value="{{ __('Registration ID') }}"/>
                    <select wire:model="registrationId" wire:loading.attr="disabled" autofocus required>
                        <option value="">-- select a Registration ID --</option>
                        @foreach ($this->registrations as $registration)
                            <option value="{{ $registration->custom_id }}">{{ $registration->custom_id }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="registrationId" class="mt-2"/>
                </div>
                <div class="mt-4 col-span-8">
                    <x-jet-label for="balance" value="{{ __('Running Balance') }}"/>
                    <input wire:model="balance" wire:loading.attr="disabled" type="text" readonly>
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('addingPayment')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="save" wire:loading.attr="disabled">
            {{ __('Proceed To Payment') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
