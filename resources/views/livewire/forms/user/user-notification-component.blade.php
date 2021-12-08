<div>
    <div class="w-full p-4 bg-white shadow-sm">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </div>

    <div class="w-full max-w-4xl mx-auto p-4 sm:px-6 lg:px-8">
        <div class="w-full py-10 sm:px-6 lg:px-8">
            @forelse ($notifications as $notification)
                <div class="my-2 p-4 rounded-lg border-b border-gray-200 {{ is_null($notification->read_at) ? 'bg-blue-50' : '' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if (array_key_exists('senderPhotoUrl', $notification->data))
                                <img class="h-8 sm:h-12 w-8 sm:w-12 rounded-full object-cover shadow-sm" src="{{ $notification->data['senderPhotoUrl'] == '' ? $school_profile_photo_path : $notification->data['senderPhotoUrl'] }}" alt="avatar">
                            @else
                                <img class="h-8 sm:h-12 w-8 sm:w-12 rounded-full object-cover shadow-sm" src="{{ $school_profile_photo_path ?? '' }}" alt="avatar">
                            @endif

                            @if (array_key_exists('sender', $notification->data))
                                <h1 class="font-bold mx-2">{{ $notification->data['sender'] == '' ? $school_name : $notification->data['sender'] }}</h1>
                            @else
                                <h1 class="font-bold mx-2">{{ $school_name ?? '' }}</h1>
                            @endif
                        </div>
                        <div>
                            <span class="italic text-gray-400 mx-2">{{ $notification->created_at->diffForHumans() ?? '' }}</span>
                        </div>
                    </div>
                    <div class="pt-6">
                        <h1>{{ $notification->data['title'] ?? 'No message found.' }}</h1>
                        <p class="text-sm pt-2">{!! $notification->data['body'] ?? '' !!}</p>
                    </div>
                    @if (is_null($notification->read_at))
                        <div class="flex items-center justify-end">
                            <x-table.nav-button wire:click="markAsRead('{{$notification->id}}')" wire:key="nav-button-{{$notification->id}}">
                                <svg class="mx-1 inline h-5 w-5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                                Mark as read
                            </x-table.nav-button>
                        </div>
                    @endif
                </div>
            @empty
                <x-table.no-result>No notifications found. 🤔</x-table.no-result>
                <x-jet-section-border/>
            @endforelse

            {{ $notifications->links('partials.pagination-link') }}
        </div>
    </div>
</div>
