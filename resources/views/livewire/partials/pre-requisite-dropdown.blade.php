<div class="grid grid-cols-8 col-span-8">
    @if(filled($preRequisites))
        <div class="mt-4 col-span-8">
            <x-jet-label for="pre-requisite" value="{{ __('Pre-requisite') }}" />
            <div class="flex flex-wrap mt-2">
                @foreach ($preRequisiteSubjects as $index => $requisite)
                    <div class="mr-2 my-2">
                        <div class="flex">
                            <select wire:model="preRequisiteSubjects.{{ $index }}" name="preRequisiteSubjects[{{ $index }}]" class="w-full bg-white flex-1 p-2 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-l-md shadow-sm">
                                @forelse ($preRequisites as $preRequisite)
                                    @if ($loop->first)
                                        <option value="">-- choose a pre-requisite --</option>
                                    @endif
                                    <option value="{{ $preRequisite->id }}">{{ $preRequisite->title }}</option>
                                @empty
                                    <option value="">No records</option>
                                @endforelse
                            </select>
                            <button wire:click.prevent="removeSubject({{ $index }})" class="bg-red-500 hover:bg-red-700 items-center px-3 py-2 border border-transparent rounded-r-md font-semibold text-xs text-white focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-2 col-span-8 flex">
            <x-jet-button class="flex items-end border border-indigo-500 hover:bg-gray-200 text-indigo-500" wire:click.prevent="addSubject" wire:loading.attr="disabled">
                <span>{{ __('Add Pre Requisite') }}</span>
            </x-jet-button>
        </div>
    @endif
</div>
