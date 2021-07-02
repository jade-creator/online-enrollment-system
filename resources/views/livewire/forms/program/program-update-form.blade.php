<div class="pt-5 px-4 lg:pl-5 w-full h-full overflow-y-auto scrolling-touch flex-1">
    <div class="w-full mb-6 pt-3">
        <div class="mb-4 pb-3 border-b-2">
            <div class="flex flex-row items-center justify-between">
                <div class="flex flex-col">
                    <div class="text-xl">{{ __('Program Details')}}</div>
                    <div class="text-xs text-blue-500 font-semibold">Update Program</div>
                </div>
                <div class="flex-shrink-0 space-x-2">
                    <a href="{{route('admin.programs.view')}}" class="focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 border border-gray-300 btn btn-default text-gray-500 py-2.5 px-4 font-bold text-xs rounded-lg">{{ __('See List')}}</a>
                </div>
            </div>
        </div>

        <div class="-my-2 overflow-x-auto">
            <div class="py-2 align-middle inline-block min-w-full ">
                <form wire:submit.prevent="update">
                    <div class="grid grid-cols-3 gap-6">
                        <div class="mt-3 col-span-4 lg:col-start-2 lg:col-end-3">
                            <div class="mt-4">
                                <x-jet-label for="code" value="{{ __('Code') }}" />
                                <x-jet-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('program.code')" autofocus required wire:model.defer="program.code" wire:loading.attr="disabled"/>
                                <x-jet-input-error for="code" class="mt-2"/>
                            </div>
                    
                            <div class="mt-4">
                                <x-jet-label for="program" value="{{ __('Program') }}" />
                                <x-jet-input id="program" class="block mt-1 w-full" type="text" name="program" :value="old('program.program')" required wire:model.defer="program.program" wire:loading.attr="disabled"/>
                                <x-jet-input-error for="program" class="mt-2"/>
                            </div>
                    
                            <div class="mt-4">
                                <x-jet-label for="description" value="{{ __('Description') }}" />
                                <x-jet-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('program.description')" required wire:model.defer="program.description" wire:loading.attr="disabled"/>
                                <x-jet-input-error for="description" class="mt-2"/>
                            </div>
                            
                            <x-jet-button class="py-2 block mt-7 w-full bg-green-500 hover:bg-green-600">
                                {{ __('Update Program')}}
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>