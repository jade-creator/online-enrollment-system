<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{-- {{ __('Update your account\'s profile information and email address.') }} --}}
        {{ __('') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6">
            <!-- Profile Photo -->
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-5">
                    <!-- Profile Photo File Input -->
                    <input type="file" class="hidden"
                                wire:model="photo"
                                x-ref="photo"
                                x-on:change="
                                        photoName = $refs.photo.files[0].name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            photoPreview = e.target.result;
                                        };
                                        reader.readAsDataURL($refs.photo.files[0]);
                                " />

                    <x-jet-label for="photo" value="{{ __('Profile picture') }}" />

                    <!-- Current Profile Photo -->
                    <div class="mt-2" x-show="! photoPreview">
                        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-32 w-32 object-cover">
                    </div>

                    <!-- New Profile Photo Preview -->
                    <div class="mt-2" x-show="photoPreview">
                        <span class="block rounded-full w-20 h-20"
                            x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>

                    <x-jet-secondary-button class="mt-2 mr-2 hover:bg-gray-100" type="button" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select a new photo') }}
                    </x-jet-secondary-button>

                    @if ($this->user->profile_photo_path)
                        <x-jet-secondary-button type="button hover:bg-gray-100" class="mt-2" wire:click="deleteProfilePhoto">
                            {{ __('Remove photo') }}
                        </x-jet-secondary-button>
                        <p class="mt-3 text-xs text-gray-500 font-semibold">{{ __("Click 'Update Profile' after selecting a new photo to save.")}}</p>
                    @endif

                    <x-jet-input-error for="photo" class="mt-2" />
                </div>
            @endif
        </div>

        {{-- <div class="col-span-6 sm:col-span-4"> --}}
        <!-- Name -->
        <div class="col-span-6">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <p class="mt-3 text-xs text-gray-500 font-semibold">{{ __("Your name may appear around ". config('app.name') ." so it should be appropriate.")}}</p>
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>
        {{-- </div> --}}
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 text-green-500 font-bold" on="saved">
            {{ __('Saved successfuly!') }}
        </x-jet-action-message>

        <x-jet-button class="bg-indigo-700 hover:bg-indigo-800" wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save profile') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
