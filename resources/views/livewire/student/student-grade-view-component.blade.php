<div class="w-full flex flex-1 scrolling-touch">
    <x-table.filter>
        <div name='slot'>
            <div class="my-4">
                <h3 class="font-bold text-md">{{ __('Types')}}</h3>
                <div class="relative w-full bg-white pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                    <select wire:model="typeId" wire:loading.attr="disabled" id="type" aria-label="types" class="w-full bg-white flex-1 px-0 py-1 tracking-wide focus:outline-none border-0 focus:ring focus:ring-white focus:ring-opacity-0">
                        @forelse ($this->types as $type)
                            @if ($loop->first)
                                <option value="">-- choose a type --</option>
                            @endif
                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                        @empty
                            <option value="">No records</option>
                        @endforelse
                    </select>
                </div>
            </div>
        </div>
    </x-table.filter>

    <!-- Module -->
    <div class="min-h-screen w-full py-8 px-8">

        <div class="mb-4 pb-3 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-between">
                    <div class="text-2xl font-bold text-gray-500">Grades</div>
                </div>
            </div>
        </div>

        <x-table.main>
            <x-slot name="paginationLink">
                {{ $registrations->links() }} 
            </x-slot>

            <x-slot name="head">
                <div class="col-span-1 pl-2" id="columnTitle">
                    <x-table.sort-button nameButton="reg. ID" event="sortFieldSelected('id')"/>
                </div>
                <x-table.column-title columnTitle="stud. ID" class="col-span-3"/>
                <x-table.column-title columnTitle="level" class="col-span-3"/>
                <x-table.column-title columnTitle="section" class="col-span-3"/>
                <x-table.column-title columnTitle="status" class="col-span-1"/>
                <div class="col-span-1">
                    <x-table.sort-button nameButton="latest" event="sortFieldSelected('created_at')"/>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($registrations as $registration)
                    <div id="{{ $registration->id }}" x-data="{ open: false }">
                        <div @click="open = ! open" 
                             @click.away="open = false"
                             @close.stop="open = false"
                             class="w-full p-2 my-1 rounded-md shadow hover:shadow-md bg-white border-t border-l border-r border-gray-200 border-opacity-80 cursor-pointer">
                            <div class="grid grid-cols-12 gap-2">
                                <div class="flex items-center justify-start col-span-12 md:col-span-1 truncate md:border-0 border-t border-gray-300 font-bold text-xs pl-2">{{ $registration->id ?? 'N/A' }}</div>
                                <div class="flex items-center justify-start col-span-12 md:col-span-3 truncate md:border-0 border-t border-gray-300 font-bold text-xs">{{ $registration->student->isStudent ? $registration->student->custom_id : '--' }}</div>
                                <div class="flex items-center justify-start col-span-12 md:col-span-3 truncate md:border-0 border-t border-gray-300 font-bold text-xs">{{ $registration->prospectus->level->level ?? 'N/A' }}</div>
                                <div class="flex items-center justify-start col-span-12 md:col-span-3 truncate md:border-0 border-t border-gray-300 font-bold text-xs">{{ $registration->section->name ?? '--' }}</div>
                                <div class="flex items-center justify-start col-span-12 md:col-span-1 truncate md:border-0 border-t border-gray-300 font-bold text-xs">{{ $registration->status->name ?? 'N/A' }}</div>
                                <div class="flex items-center justify-center col-span-12 md:col-span-1 md:border-0 border-t border-gray-300">
                                    <x-jet-dropdown align="right" width="60" dropdownClasses="z-10 shadow-2xl">
                                        <x-slot name="trigger">
                                            <span class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center px-2 py-2 border border-transparent rounded-full text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:bg-gray-100 active:bg-gray-100 transition ease-in-out duration-150">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <circle cx="5" cy="12" r="1"></circle>
                                                        <circle cx="12" cy="12" r="1"></circle>
                                                        <circle cx="19" cy="12" r="1"></circle>
                                                    </svg>
                                                </button>
                                            </span>
                                        </x-slot>
            
                                        <x-slot name="content">
                                            <div class="w-60">
                                                <div class="block px-4 py-3 text-sm text-gray-500 font-bold">
                                                    {{ __('Actions') }}
                                                </div>
                                                <div>
                                                    <a href="{{ route('pre.registration.view', ['regId' => $registration->id]) }}">
                                                        <button class="flex w-full px-4 py-2 hover:bg-gray-200 outline-none focus:outline-none transition-all duration-300 ease-in-out">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path>
                                                                </svg>
                                                            <p class="pl-2">{{ __('View')}}</p>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </div>
                            </div>
                        </div>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform scale-90"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-90"
                             class="w-full py-2 px-4 my-1 rounded shadow hover:shadow-md bg-white border-t border-l border-r border-gray-200 border-opacity-80"
                             x-cloak>

                            <div class="py-4 grid grid-cols-12 gap-2">
                                <x-table.column-title columnTitle="subject" class="col-span-3 text-blue-500"/>
                                <x-table.column-title columnTitle="title" class="col-span-4"/>
                                <x-table.column-title columnTitle="grade" class="col-span-3"/>
                                <x-table.column-title columnTitle="remark" class="col-span-2"/>
                            </div>
                            <div class="grid grid-cols-12 gap-2">
                                @forelse ($registration->grades as $grade)
                                    <div class="pb-3 col-span-12 md:col-span-3 font-bold text-xs">
                                        <p class="truncate">{{ $grade->subject->code ?? 'N/A' }}</p>
                                    </div>
                                    <div class="pb-3 col-span-12 md:col-span-4 font-bold text-xs">
                                        <p class="truncate">{{ $grade->subject->title ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-span-12 md:col-span-3 font-bold text-xs">
                                        <p class="truncate">
                                            {{ $grade->value ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="col-span-12 md:col-span-2 font-bold text-xs">
                                        <p class="truncate">
                                            {{ $grade->mark->name ?? 'N/A' }}
                                        </p>
                                    </div>
                                @empty
                                    <div class="py-4 col-span-12 md:col-span-12 font-bold text-xs">
                                        <p class="truncate text-center">No added subject under the prospectus.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @empty 
                    <x-table.no-result title="No registration found.🤔"/>
                @endforelse
            </x-slot>
        </x-table.main>
    </div>

    <div wire:loading wire:target="paginateValue, search, previousPage, nextPage">
        @include('partials.loading')
    </div>
</div>
