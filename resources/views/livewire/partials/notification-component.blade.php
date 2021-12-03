<div>
    <!-- Notification -->
    <div class="relative mx-1">
        <x-jet-dropdown align="right" width="80" dropdownClasses="z-50 shadow-lg">
            <x-slot name="trigger">
                <button title="Notifications" class="text-white hover:text-gray-400 focus:text-blue-500 text-sm focus:outline-none rounded-full focus:bg-gray-700 transition duration-150 ease-in-out h-full p-1.5">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                    @if ($unreadNotificationsCount != 0)
                        <span class="absolute -top-1 rounded-full text-xs h-4 {{ $unreadNotificationsCount >= 100 ? 'w-6' : 'w-4' }} bg-red-600 z-50 text-white">
                            {{ $unreadNotificationsCount >= 100 ? $unreadNotificationsCount.'+' : $unreadNotificationsCount }}
                        </span>
                    @endif
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="max-h-60 sm:max-h-96 overflow-y-auto sidebar">
                    <div class="sticky top-0 flex items-center justify-between px-4 py-3 text-xs text-gray-400 bg-white rounded-md">
                        <div>{{ __('Notifications') }}</div>
                        @if (count($notifications) > 10)
                            <div class="text-blue-500 hover:underline"><a href="{{ route('user.notification.index') }}">See all</a></div>
                        @endif
                    </div>

                    @if (count($notifications) == 0)
                        <p class="w-full px-4 py-3 border-b hover:bg-gray-100 -mx-2 text-gray-600 text-sm text-center">No notifications found. 🤔</p>
                    @else
                        @foreach ($notifications->take(10) as $notification)
                            <x-jet-dropdown-link href="{{ route('user.notification.index', ['search' => $notification->id]) }}" class="border-b {{ is_null($notification->read_at) ? 'bg-blue-50 hover:bg-blue-100' : '' }}">
                                <span class="block flex items-start py-3">
                                    <img class="h-8 sm:h-12 w-8 sm:w-12 rounded-full object-cover" src="{{ $notification->data['by']['profile_photo_url'] ?? $school_profile_photo_path }}" alt="avatar">
                                    <span class="font-bold text-gray-600 text-xs sm:text-sm mx-2">{{ $notification->data['by']['person']['firstname'] ?? $school_name }} {{ $notification->data['by']['person']['lastname'] ?? '' }}
                                        <span class="font-normal">- {{ $notification->data['title'] ?? 'No message found.' }}
                                            <span class="italic text-gray-400">{{ $notification->created_at->diffForHumans() ?? '' }}</span>
                                        </span>
                                    </span>
                                </span>
                            </x-jet-dropdown-link>
                        @endforeach
                        <button wire:click="markAllAsRead" class="flex items-center justify-center text-xs sm:text-sm focus:outline-none hover:text-white hover:bg-red-400 transition duration-150 ease-in-out h-full w-full py-3">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                            <span class="mx-2">Mark all as read</span>
                        </button>
                    @endif
                </div>
            </x-slot>
        </x-jet-dropdown>
    </div>
</div>
