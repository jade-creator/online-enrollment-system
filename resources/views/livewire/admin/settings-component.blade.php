<div>
    <div class="w-full p-4 bg-white shadow-sm">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </div>

    <div class="w-full max-w-4xl mx-auto p-4 sm:px-6 lg:px-8">
        <div class="w-full py-10 sm:px-6 lg:px-8">
            <x-jet-form-section submit="">
                <x-slot name="title">
                    {{ __('School Information') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6">
                        <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-5">
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
                                "/>

                            <x-jet-label for="photo" value="{{ __('School Logo') }}" />

                            <!-- Current Profile Photo -->
                            <div class="mt-2" x-show="! photoPreview" x-cloak>
                                <img src="{{ $setting->profile_photo_url_preview }}" alt="{{ $setting->school_name }}" class="rounded-full h-32 w-32 object-cover">
                            </div>

                            <!-- New Profile Photo Preview -->
                            <div class="mt-2" x-show="photoPreview">
                                <span class="block rounded-full w-32 h-32"
                                      x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                                </span>
                            </div>

                            <x-jet-secondary-button class="mt-2 mr-2 hover:bg-gray-100" type="button" x-on:click.prevent="$refs.photo.click()">
                                {{ __('Select a new logo') }}
                            </x-jet-secondary-button>

                            @if ($setting->profile_photo_path)
                                <x-jet-secondary-button class="mt-2 hover:bg-gray-100" wire:click.prevent="deleteProfilePhoto" formaction="#">
                                    {{ __('Remove photo') }}
                                </x-jet-secondary-button>
                                <p x-cloak class="mt-3 text-xs text-gray-500 font-semibold">{{ __("Click 'Update Profile' after selecting a new photo to save.")}}</p>
                            @endif

                            <x-jet-input-error for="photo" class="mt-2" />
                        </div>
                    </div>

                    <div class="col-span-6">
                        <x-jet-label for="name" value="{{ __('School Name') }}" />
                        <x-jet-input id="name" type="text" class="mt-2 block w-full" wire:model.defer="setting.school_name" autocomplete="name" />
                        <x-jet-input-error for="setting.school_name" class="mt-2" />
                    </div>

                    <div class="col-span-6">
                        <x-jet-label for="email" value="{{ __('School Email') }}" />
                        <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="setting.school_email" />
                        <x-jet-input-error for="setting.school_email" class="mt-2" />
                    </div>

                    <div class="col-span-6">
                        <x-jet-label for="address" value="{{ __('School Address') }}" />
                        <textarea id="address" class="h-32 mt-2 block w-full" wire:model.defer="setting.school_address"></textarea>
                        <x-jet-input-error for="setting.school_address" class="mt-2" />
                    </div>

                    <div wire:ignore class="col-span-6">
                        <x-jet-label for="settings-school-description" value="{{ __('School Description') }}" />
                        <textarea id="settings-school-description" class="h-32 mt-2 block w-full" wire:model.defer="setting.school_description">{!! $setting->school_description !!}</textarea>
                        <x-jet-input-error for="setting.school_description" class="mt-2" />
                    </div>

                    <div class="col-span-6">
                        <x-jet-label for="max-slots" value="{{ __('Maximum slots per section') }}" />
                        <x-jet-input id="max-slots" type="number" min="1" max="100" class="mt-1 block w-full" wire:model.defer="setting.max_slots" />
                        <x-jet-input-error for="setting.max_slots" class="mt-2" />
                    </div>
                </x-slot>

                <x-slot name="actions">
                    <x-jet-button wire:click.stop="updateSchoolInformation" class="bg-indigo-700 hover:bg-indigo-800" wire:target="photo">
                        {{ __('Update') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-form-section>

            <x-form.unflashed-alert class="my-4" type="info">
                Note: Changes can take effect in the system for about 10 minutes after updating it successfully. Click "update" when selecting a new logo.
            </x-form.unflashed-alert>
            <x-jet-section-border/>

            <x-jet-form-section submit="updatePayments">
                <x-slot name="title">
                    {{ __('Payments') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6">
                        <x-jet-label for="downpayment_minimum_percentage" value="{{ __('Downpayment Percentage %') }}" />
                        <x-jet-input id="downpayment_minimum_percentage" type="number" min="1" max="100" class="mt-1 block w-full" wire:model.defer="setting.downpayment_minimum_percentage" />
                        <x-jet-input-error for="setting.downpayment_minimum_percentage" class="mt-2" />
                    </div>

                    <div class="col-span-6">
                        <x-jet-label for="penalty_percentage" value="{{ __('Penalty Percentage %') }}" />
                        <x-jet-input id="penalty_percentage" type="number" min="1" max="100" class="mt-1 block w-full" wire:model.defer="setting.penalty_percentage" />
                        <x-jet-input-error for="setting.penalty_percentage" class="mt-2" />
                    </div>
                </x-slot>

                <x-slot name="actions">
                    <x-jet-button class="bg-indigo-700 hover:bg-indigo-800" wire:target="updatePayments">
                        {{ __('Update') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-form-section>
            <x-jet-section-border/>

            <x-jet-form-section submit="updateProcess">
                <x-slot name="title">
                    {{ __('Processes') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6 border-b border-gray-200 py-4">
                        <div x-data="{ toggle: {{ $setting->auto_account_approval ? '1' : '0' }} }"
                             class="w-full flex items-center justify-between">

                            <div>Enable accounts auto-approval</div>

                            <div class="relative rounded-full w-12 h-6 transition duration-200 ease-linear"
                                 :class="[toggle === 1 ? 'bg-green-400' : 'bg-red-400']">

                                <label for="toggle-auto_account_approval"
                                       class="absolute left-0 bg-white border-2 mb-2 w-6 h-6 rounded-full transition transform duration-100 ease-linear cursor-pointer"
                                       :class="[toggle === 1 ? 'translate-x-full border-green-400' : 'translate-x-0 border-red-400']"></label>

                                <input wire:model.defer="setting.auto_account_approval"
                                       type="checkbox" id="toggle-auto_account_approval" name="toggle-auto_account_approval"
                                       class="appearance-none w-full h-full active:outline-none focus:outline-none invisible"
                                       @click="toggle === 0 ? toggle = 1 : toggle = 0">
                            </div>
                        </div>
                        <x-jet-input-error for="setting.auto_account_approval" class="mt-2" />
                    </div>
                </x-slot>

                <x-slot name="actions">
                    <x-jet-button class="bg-indigo-700 hover:bg-indigo-800" wire:target="updateProcess">
                        {{ __('Update') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-form-section>
            <x-jet-section-border/>

            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-3">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-2xl text-gray-900">{{ 'Database Backup' }}</h3>
                    </div>
                </div>
            </div>

            <x-form.unflashed-alert class="my-4" type="warning">
                Note: Authorized Personnel only. Please be careful when sharing the database backups to anyone, it contains sensitive information.
                <a href="{{ route('admin.backup') }}" class="underline hover:text-indigo-500">Backup now.</a>
            </x-form.unflashed-alert>
            <x-jet-section-border/>
        </div>
    </div>

    @if (session()->has('alert'))
        <x-form.alert type="{{session('alert')['type']}}">{!!session()->pull('alert')['message']!!}</x-form.alert>
    @endif

    @push('scripts')
        <script src="{{ asset('js/alert.js') }}"></script>

        <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>

        <script>
            ClassicEditor
                .create(document.querySelector('#settings-school-description'), {
                    removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
                })
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('setting.school_description', editor.getData());
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush
</div>
