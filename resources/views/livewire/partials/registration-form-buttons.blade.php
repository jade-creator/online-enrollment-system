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
                <x-icons.pending-icon/>
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
                <x-icons.enroll-icon/>
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

    <div>@include('partials.loading')</div>

    @if (session()->has('alert'))
        <x-form.alert type="{{session('alert')['type']}}">{!!session()->pull('alert')['message']!!}</x-form.alert>
    @endif

    @push('scripts')
        <script src="{{ asset('js/alert.js') }}"></script>
    @endpush
</div>
