<div>
    <div class="w-full mb-10 flex items-center justify-start">
        @can ('confirm', $registration)
            <x-jet-button wire:click.prevent="finalizeConfirm" wire:loading.attr="disabled" class="ml-2 bg-green-500 hover:bg-green-700 flex items-end">
                <x-icons.fee-icon/>
                <span class="ml-2">{{ __('Confirm') }}</span>
            </x-jet-button>
        @endcan

        @can ('pending', $registration)
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
        @elsecan ('selectSection', $registration)
            <x-jet-button wire:click.prevent="submit" wire:loading.attr="disabled" class="ml-2 bg-indigo-500 hover:bg-indigo-700 flex items-end">
                <span>{{ __('Submit') }}</span>
            </x-jet-button>
        @endcan

        @can ('submitted', $registration)
            <x-jet-button class="bg-indigo-600 disabled:opacity-50 cursor-not-allowed" disabled="disabled">
                <span>{{ __('Submitted') }}</span>
            </x-jet-button>
        @endcan

        @can('enroll', $registration)
            <x-jet-button wire:click.prevent="enrollConfirm" wire:loading.attr="disabled" class="ml-2 bg-indigo-500 hover:bg-indigo-700 flex items-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="12" cy="9" r="6"></circle>
                    <polyline points="9 14.2 9 21 12 19 15 21 15 14.2" transform="rotate(-30 12 9)"></polyline>
                    <polyline points="9 14.2 9 21 12 19 15 21 15 14.2" transform="rotate(30 12 9)"></polyline>
                </svg>
                <span>{{ __('Enroll') }}</span>
            </x-jet-button>
        @endcan

        @can('reject', $registration)
            <x-jet-button wire:click.prevent="rejectConfirm" wire:loading.attr="disabled" class="ml-2 bg-red-500 hover:bg-red-700 flex items-end">
                <x-icons.reject-icon/>
                <span class="ml-2">{{ __('Reject') }}</span>
            </x-jet-button>
        @endcan
    </div>

    <div wire:loading>
        @include('partials.loading')
    </div>
</div>
