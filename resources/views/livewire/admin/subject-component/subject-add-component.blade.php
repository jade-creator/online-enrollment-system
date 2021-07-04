<div class="pt-5 px-4 lg:pl-5 w-full h-full overflow-y-auto scrolling-touch flex-1">
    <div class="w-full mb-6 pt-3">
        <div class="mb-4 pb-3 border-b-2">
            <div class="flex flex-row items-center justify-between">
                <div class="flex flex-col">
                    <div class="text-xl">{{ __('User Details')}}</div>
                    <div class="text-xs text-blue-500 font-semibold">Add Description</div>
                </div>
                <div class="flex-shrink-0 space-x-2">
                    <a href="{{ route('admin.subjects.view') }}" class="focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 border border-gray-300 btn btn-default text-gray-500 py-2.5 px-4 font-bold text-xs rounded-lg">{{ __('See List')}}</a>
                </div>
            </div>
        </div>

        <div class="-my-2 overflow-x-auto">
            <div class="py-2 align-middle inline-block min-w-full ">
                <form wire:submit.prevent="create">
                    <div class="grid grid-cols-3 gap-6">
                        <div class="mt-3 col-span-4 lg:col-start-2 lg:col-end-3">
                            <div class="mt-4">
                                <x-jet-label for="code" value="{{ __('Code') }}" />
                                <x-jet-input wire:model.defer="subject.code" wire:loading.attr="disabled" id="name" class="block mt-1 w-full" type="text" name="name" autofocus required />
                                <x-jet-input-error for="subject.code" class="mt-2"/>
                            </div>
                    
                            <div class="mt-4">
                                <x-jet-label for="title" value="{{ __('Title') }}" />
                                <x-jet-input wire:model.defer="subject.title" wire:loading.attr="disabled" id="title" class="block mt-1 w-full" type="text" name="title" autofocus required />
                                <x-jet-input-error for="subject.title" class="mt-2"/>
                            </div>
                    
                            <div class="mt-4">
                                <x-jet-label for="unit" value="{{ __('Unit') }}" />
                                <x-jet-input wire:model.defer="subject.unit" wire:loading.attr="disabled" id="unit" class="block mt-1 w-full" type="number" name="unit" required />
                                <x-jet-input-error for="subject.unit" class="mt-2"/>
                            </div>
                            
                            <x-jet-button class="py-2 block mt-7 w-full bg-green-500 hover:bg-green-600">
                                {{ __('Create Subject')}}
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>