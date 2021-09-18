<div>
    <div class="w-full mb-10 flex items-center justify-start">
        @if ($registration->status->name == 'confirming')
            <x-jet-button class="bg-indigo-600 disabled:opacity-50 cursor-not-allowed" disabled="disabled">
                <span>{{ __('Submitted') }}</span>
            </x-jet-button>
        @else
            @can ('selectSection', $registration)
                <x-jet-button wire:click.prevent="submit" wire:loading.attr="disabled" class="ml-2 bg-indigo-500 hover:bg-indigo-700 flex items-end">
                    <span>{{ __('Submit') }}</span>
                </x-jet-button>
            @endcan
        @endif

        @can('enroll', $registration)
            <x-jet-button wire:click.prevent="$toggle('enrollingStudent')" wire:loading.attr="disabled" class="ml-2 bg-indigo-500 hover:bg-indigo-700 flex items-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="12" cy="9" r="6"></circle>
                    <polyline points="9 14.2 9 21 12 19 15 21 15 14.2" transform="rotate(-30 12 9)"></polyline>
                    <polyline points="9 14.2 9 21 12 19 15 21 15 14.2" transform="rotate(30 12 9)"></polyline>
                </svg>
                <span>{{ __('Enroll') }}</span>
            </x-jet-button>
        @elsecan('pending', $registration)
            <x-jet-button wire:click.prevent="pendingConfirm" wire:loading.attr="disabled" class="ml-2 bg-yellow-500 hover:bg-yellow-700 flex items-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M15 4.55a8 8 0 0 0 -6 14.9m0 -4.45v5h-5"></path>
                    <line x1="18.37" y1="7.16" x2="18.37" y2="7.17"></line>
                    <line x1="13" y1="19.94" x2="13" y2="19.95"></line>
                    <line x1="16.84" y1="18.37" x2="16.84" y2="18.38"></line>
                    <line x1="19.37" y1="15.1" x2="19.37" y2="15.11"></line>
                    <line x1="19.94" y1="11" x2="19.94" y2="11.01"></line>
                </svg>
                <span>{{ __('Pending') }}</span>
            </x-jet-button>
        @endcan

        @can('reject', $registration)
            <x-jet-button wire:click.prevent="rejectConfirm" wire:loading.attr="disabled" class="ml-2 bg-red-500 hover:bg-red-700 flex items-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="12" cy="12" r="9"></circle>
                    <line x1="5.7" y1="5.7" x2="18.3" y2="18.3"></line>
                </svg>
                <span>{{ __('Reject') }}</span>
            </x-jet-button>
        @endcan
    </div>

    <x-jet-dialog-modal wire:model="enrollingStudent" maxWidth="sm">
        <x-slot name="title">
            {{ __('Enroll Student') }}
        </x-slot>

        <x-slot name="content">
            <form>
                <div class="col-span-6 mb-2">
                    <x-jet-label for="student_id" value="{{ __('Auto Generated Student ID') }}" class="my-2" />
                    <input wire:model="studentId" readonly type="text" id="student_id" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                </div>

                <div class="col-span-6">
                    <x-jet-label for="student_type" value="{{ __('Section') }}" class="my-2"/>
                    <select wire:model="registration.section_id" wire:loading.attr="disabled" id="student_type" class="w-full flex-1 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        @forelse ($sections as $section)
                            @if ($loop->first)
                                <option value="" selected>-- choose a section --</option>
                            @endif
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @empty
                            <option value="">No records found</option>
                        @endforelse
                    </select>
                    <x-jet-input-error for="registration.section_id" class="mt-2"/>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('enrollingStudent')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="enroll" wire:loading.attr="disabled">
                {{ __('Submit') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
