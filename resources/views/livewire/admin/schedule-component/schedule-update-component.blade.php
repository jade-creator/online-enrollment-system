<x-jet-dialog-modal wire:model="viewingSchedule">
    <x-slot name="title">
        {{ __('Schedule Maintenance') }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 grid grid-cols-8 gap-2 col-span-8">
                    <div class="col-span-8">
                        <x-jet-label for="monday" value="{{ __('Monday') }}" />
                    </div>
                    <div class="col-span-4">
                        <x-jet-label for="start" value="{{ __('Start Time') }}" />
                        <x-jet-input wire:model.defer="schedule.start_time_monday" id="start_time_monday" class="block mt-1 w-full" type="time" name="start_time_monday" autofocus required/>
                        <x-jet-input-error for="schedule.start_time_monday" class="mt-2"/>
                    </div>
                    <div class="col-span-4">
                        <x-jet-label for="end" value="{{ __('End Time') }}" />
                        <x-jet-input wire:model.defer="schedule.end_time_monday" id="end_time_monday" class="block mt-1 w-full" type="time" name="end_time_monday" autofocus required/>
                        <x-jet-input-error for="schedule.end_time_monday" class="mt-2"/>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-8 gap-2 col-span-8">
                    <div class="col-span-8">
                        <x-jet-label for="tuesday" value="{{ __('Tuesday') }}" />
                    </div>
                    <div class="col-span-4">
                        <x-jet-label for="start" value="{{ __('Start Time') }}" />
                        <x-jet-input wire:model.defer="schedule.start_time_tuesday" id="start_time_tuesday" class="block mt-1 w-full" type="time" name="start_time_tuesday" autofocus required/>
                        <x-jet-input-error for="schedule.start_time_tuesday" class="mt-2"/>
                    </div>
                    <div class="col-span-4">
                        <x-jet-label for="end" value="{{ __('End Time') }}" />
                        <x-jet-input wire:model.defer="schedule.end_time_tuesday" id="end_time_tuesday" class="block mt-1 w-full" type="time" name="end_time_tuesday" autofocus required/>
                        <x-jet-input-error for="schedule.end_time_tuesday" class="mt-2"/>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-8 gap-2 col-span-8">
                    <div class="col-span-8">
                        <x-jet-label for="wednesday" value="{{ __('Wednesday') }}" />
                    </div>
                    <div class="col-span-4">
                        <x-jet-label for="start" value="{{ __('Start Time') }}" />
                        <x-jet-input wire:model.defer="schedule.start_time_wednesday" id="start_time_wednesday" class="block mt-1 w-full" type="time" name="start_time_wednesday" autofocus required/>
                        <x-jet-input-error for="schedule.start_time_wednesday" class="mt-2"/>
                    </div>
                    <div class="col-span-4">
                        <x-jet-label for="end" value="{{ __('End Time') }}" />
                        <x-jet-input wire:model.defer="schedule.end_time_wednesday" id="end_time_wednesday" class="block mt-1 w-full" type="time" name="end_time_wednesday" autofocus required/>
                        <x-jet-input-error for="schedule.end_time_wednesday" class="mt-2"/>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-8 gap-2 col-span-8">
                    <div class="col-span-8">
                        <x-jet-label for="thursday" value="{{ __('Thursday') }}" />
                    </div>
                    <div class="col-span-4">
                        <x-jet-label for="start" value="{{ __('Start Time') }}" />
                        <x-jet-input wire:model.defer="schedule.start_time_thursday" id="start_time_thursday" class="block mt-1 w-full" type="time" name="start_time_thursday" autofocus required/>
                        <x-jet-input-error for="schedule.start_time_thursday" class="mt-2"/>
                    </div>
                    <div class="col-span-4">
                        <x-jet-label for="end" value="{{ __('End Time') }}" />
                        <x-jet-input wire:model.defer="schedule.end_time_thursday" id="end_time_thursday" class="block mt-1 w-full" type="time" name="end_time_thursday" autofocus required/>
                        <x-jet-input-error for="schedule.end_time_thursday" class="mt-2"/>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-8 gap-2 col-span-8">
                    <div class="col-span-8">
                        <x-jet-label for="friday" value="{{ __('Friday') }}" />
                    </div>
                    <div class="col-span-4">
                        <x-jet-label for="start" value="{{ __('Start Time') }}" />
                        <x-jet-input wire:model.defer="schedule.start_time_friday" id="start_time_friday" class="block mt-1 w-full" type="time" name="start_time_friday" autofocus required/>
                        <x-jet-input-error for="schedule.start_time_friday" class="mt-2"/>
                    </div>
                    <div class="col-span-4">
                        <x-jet-label for="end" value="{{ __('End Time') }}" />
                        <x-jet-input wire:model.defer="schedule.end_time_friday" id="end_time_friday" class="block mt-1 w-full" type="time" name="end_time_friday" autofocus required/>
                        <x-jet-input-error for="schedule.end_time_friday" class="mt-2"/>
                    </div>
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('viewingSchedule')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="update" wire:loading.attr="disabled">
            {{ __('Update') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
