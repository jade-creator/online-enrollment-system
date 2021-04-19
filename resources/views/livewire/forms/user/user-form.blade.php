<form wire:submit.prevent="create">
    <div class="grid grid-cols-3 gap-6">
        <div class="mt-3 col-span-4 lg:col-start-2 lg:col-end-3">
            <div class="mt-4">
                <x-jet-label for="role" value="{{ __('Role') }}" />
                <select name="role" id="role" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required wire:model.defer="role" wire:loading.attr="disabled">
                    <option value="">Choose a role</option>
                    @if ($roles->count())   
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    @endif
                </select>
                <x-jet-input-error for="role" class="mt-2"/>
            </div>
    
            <div class="mt-4">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus autocomplete="name" placeholder="eg. John Doe" required wire:model.defer="name" wire:loading.attr="disabled"/>
                <x-jet-input-error for="name" class="mt-2"/>
            </div>
    
            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="example@gmail.com" required wire:model.defer="email" wire:loading.attr="disabled"/>
                <x-jet-input-error for="email" class="mt-2"/>
            </div>
    
            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" required wire:model.defer="password" wire:loading.attr="disabled"/>
                <x-jet-input-error for="password" class="mt-2"/>
            </div>
    
            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" required wire:model.defer="password_confirmation" wire:loading.attr="disabled"/>
            </div>
            
            <x-jet-button class="py-2 block mt-7 w-full bg-green-500 hover:bg-green-600">
                {{ __('Create User')}}
            </x-jet-button>
        </div>
    </div>
</form>
