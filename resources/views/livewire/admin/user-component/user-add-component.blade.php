<div class="w-full scrolling-touch">
    <div class="h-content w-full py-8 px-8">
        <x-table.title tableTitle="User Maintenance"></x-table.title>

        <x-table.main>
            <x-slot name="filter"></x-slot>
            <x-slot name="paginationLink"></x-slot>
            <x-slot name="head"></x-slot>

            <x-slot name="body">
                <div class="grid place-items-center">
                    <x-jet-form-section submit="" class="w-3/4">
                        <x-slot name="title">
                            Create New User
                        </x-slot>

                        <x-slot name="description">Please fill out the form with correct data.</x-slot>

                        <x-slot name="form">
                            <form>
                                <div class="col-span-6">
                                    <x-jet-label for="name" value="{{ __('Name') }}" />
                                    <x-jet-input wire:model.defer="name" wire:loading.attr="disabled" type="text" name="name" placeholder="eg. John Doe" autofocus required/>
                                    <x-jet-input-error for="name" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="role_id" value="{{ __('Role') }}" />
                                    <select wire:model="role_id" wire:loading.attr="disabled" name="role_id" autofocus required>
                                        <option value="">-- select a role --</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Student</option>
                                        <option value="3">Registrar</option>
                                        <option value="4">Dean</option>
                                        <option value="5">Faculty Member</option>
                                    </select>
                                    <x-jet-input-error for="role_id" class="mt-2"/>
                                </div>
                                @if ($role_id == 2)
                                    <div class="col-span-3">
                                        <x-jet-label for="student_id" value="{{ __('Student ID') }}"/>
                                        <x-jet-input wire:model.defer="student_id" id="student_id" type="text" name="student_id" autofocus autocomplete="student_id"/>
                                        <x-jet-input-error for="student_id" class="mt-2"/>
                                    </div>
                                @else
                                    <div class="col-span-3">
                                        <x-jet-label for="employee_id" value="{{ __('Employee ID') }}"/>
                                        <x-jet-input wire:model.defer="employee_id" id="employee_id" type="text" name="employee_id" autofocus autocomplete="employee_id"/>
                                        <x-jet-input-error for="employee_id" class="mt-2"/>
                                    </div>
                                @endif
                                <div class="col-span-3">
                                    <x-jet-label for="email" value="{{ __('Email') }}" />
                                    <x-jet-input wire:model.defer="email" wire:loading.attr="disabled" type="email" name="email" placeholder="example@gmail.com" autofocus required/>
                                    <x-jet-input-error for="email" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="password" value="{{ __('Password') }}" />
                                    <x-jet-input wire:model.defer="password" wire:loading.attr="disabled" id="password" type="password" name="password" autocomplete="new-password" required/>
                                    <x-jet-input-error for="password" class="mt-2"/>
                                </div>
                                <div class="col-span-3">
                                    <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                    <x-jet-input wire:model.defer="password_confirmation" wire:loading.attr="disabled" id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required/>
                                </div>
                            </form>
                        </x-slot>

                        <x-slot name="actions">
                            <a href="{{ route('admin.users.view') }}">
                                <x-jet-secondary-button>
                                    {{ __('Cancel') }}
                                </x-jet-secondary-button>
                            </a>

                            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="save" wire:loading.attr="disabled">
                                {{ __('Save') }}
                            </x-jet-button>
                        </x-slot>
                    </x-jet-form-section>
                    <x-jet-section-border/>
                </div>
            </x-slot>
        </x-table.main>
    </div>
</div>
