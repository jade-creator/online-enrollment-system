<div class="grid grid-cols-8 col-span-8">
    @if(filled($preRequisites))
        <div class="mt-4 col-span-8">
            <x-jet-label for="pre-requisite" value="{{ __('Pre-requisite') }}" />
            <div class="flex flex-wrap mt-2">
                @foreach ($preRequisiteSubjects as $index => $requisite)
                    <div class="mr-2 my-2">
                        <div class="flex">
                            <select wire:model="preRequisiteSubjects.{{ $index }}" name="preRequisiteSubjects[{{ $index }}]" class="bg-white flex-1 p-2 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-l-md shadow-sm">
                                <option value="">-- choose a pre-requisite --</option>
                                @forelse ($preRequisites as $preRequisite)
                                    <option value="{{ $preRequisite->id }}">{{ $preRequisite->title }}</option>
                                @empty
                                    <option value="">No records</option>
                                @endforelse
                            </select>
                            <button wire:click.prevent="removeSubject({{ $index }})" class="bg-red-500 hover:bg-red-700 items-center px-3 py-2 border border-transparent rounded-r-md font-semibold text-xs text-white focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                <x-icons.cancel-icon/>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-2 col-span-8 flex">
            @if (count($preRequisites) > count($preRequisiteSubjects))
                <x-jet-button class="flex items-end border border-indigo-500 hover:bg-gray-200 text-indigo-500" wire:click.prevent="addSubject" wire:loading.attr="disabled">
                    <span>{{ __('Add Pre Requisite') }}</span>
                </x-jet-button>
            @endif
        </div>
    @endif
</div>
