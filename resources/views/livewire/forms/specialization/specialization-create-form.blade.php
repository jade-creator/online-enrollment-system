<div class="pt-5 px-4 lg:pl-5 w-full h-full overflow-y-auto scrolling-touch flex-1">
    <div class="w-full mb-6 pt-3">
        <div class="mb-4 pb-3 border-b-2">
            <div class="flex flex-row items-center justify-between">
                <div class="flex flex-col">
                    <div class="text-xl">{{ __('Specialization Details')}}</div>
                    <div class="text-xs text-blue-500 font-semibold">Add Specialization</div>
                </div>
                <div class="flex-shrink-0 space-x-2">
                    <a href="{{route('admin.specializations.view')}}" class="focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 border border-gray-300 btn btn-default text-gray-500 py-2.5 px-4 font-bold text-xs rounded-lg">{{ __('See List')}}</a>
                </div>
            </div>
        </div>

        <div class="-my-2 overflow-x-auto">
            <div class="py-2 align-middle inline-block min-w-full ">
                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-3 gap-6">
                        <div class="mt-3 col-span-4 lg:col-start-2 lg:col-end-3">
                            <div class="mt-4">
                                <x-jet-label for="role" value="{{ __('Strand') }}" />
                                <select name="strands" id="strands" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required wire:model.defer="strandId" wire:loading.attr="disabled">
                                    <option value="">Choose a Strand</option>
                                    @if ($strands->count())   
                                        @foreach ($strands as $strand)
                                            <option value="{{ $strand->id }}">{{ $strand->strand }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-jet-input-error for="strands" class="mt-2"/>
                            </div>

                            <div class="mt-4">
                                <x-jet-label for="name" value="{{ __('Specialization') }}" />
                                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus autocomplete="name" required wire:model.defer="specialization" wire:loading.attr="disabled"/>
                                <x-jet-input-error for="name" class="mt-2"/>
                            </div>
                            
                            <x-jet-button class="py-2 block mt-7 w-full bg-green-500 hover:bg-green-600">
                                {{ __('Create Specialization')}}
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>