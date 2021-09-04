<x-jet-dialog-modal wire:model="addingUser">
    <x-slot name="title">
        {{ __('User Maintenance') }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-8">
                    <x-jet-label for="role" value="{{ __('Role') }}" />
                    <select wire:model.defer="role_id" wire:loading.attr="disabled" name="role" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" autofocus required>
                        @forelse($roles as $role)
                            @if ($loop->first)
                                <option value="" selected>-- choose a role --</option>
                            @endif
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @empty
                            <option value="">No records.</option>
                        @endforelse
                    </select>
                    <x-jet-input-error for="role_id" class="mt-2"/>
                </div>

                <div class="mt-4 col-span-8">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input wire:model.defer="name" wire:loading.attr="disabled" class="block mt-1 w-full" type="text" name="name" placeholder="eg. John Doe" autofocus required/>
                    <x-jet-input-error for="name" class="mt-2"/>
                </div>

                <div class="mt-4 col-span-8">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input wire:model.defer="email" wire:loading.attr="disabled" class="block mt-1 w-full" type="email" name="email" placeholder="example@gmail.com" autofocus required/>
                    <x-jet-input-error for="email" class="mt-2"/>
                </div>

                <div class="mt-4 col-span-8">
                    <x-jet-label for="password" value="{{ __('Password') }}" />
                    <x-jet-input wire:model.defer="password" wire:loading.attr="disabled" id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" required/>
                    <x-jet-input-error for="password" class="mt-2"/>
                </div>

                <div class="mt-4 col-span-8">
                    <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-jet-input wire:model.defer="password_confirmation" wire:loading.attr="disabled" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" required/>
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('addingUser')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="save" wire:loading.attr="disabled">
            {{ __('Add') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
