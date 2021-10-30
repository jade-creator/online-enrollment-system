<x-jet-dialog-modal wire:model="addingMembers" maxWidth="xl" :closeBtn="true">
    <x-slot name="title">
        {{ __('Faculty Members Maintenance') }}
    </x-slot>

    <x-slot name="content">
        <div class="w-full px-6 py-4">
            <input wire:model.debounce.1000ms="search" type="text" placeholder="Search" class="text-sm">
        </div>

        <div class="w-full">
            <form class="sidebar w-full max-h-96 overflow-x-hidden overflow-y-auto">
                <div wire:loading wire:target="search" class="w-full">
                    <div class="w-full h-40 text-blue-500 grid place-items-center">
                        <x-icons.loading-icon color="blue"/>
                    </div>
                </div>

                <div wire:loading.class="hidden" wire:target="search" class="w-full">
                    @forelse ($users as $user)
                        <div class="flex items-center justify-between px-2 py-3 hover:bg-gray-50 rounded-md">
                            <div class="flex items-center">
                                @if ( Laravel\Jetstream\Jetstream::managesProfilePhotos() )
                                    <div class="hidden md:block mr-4 flex-shrink-0"><img class="h-8 w-8 rounded-full object-cover" src="{{ $user->profile_photo_url ?? 'N/A' }}"/></div>
                                @endif
                                <div class="font-semibold">{{ $user->person->full_name ?? 'N/A'}}</div>
                            </div>
                            <input wire:model.defer="selected" wire:loading.attr="disabled" value="{{ $user->employee->id }}" type="checkbox" class="rounded-sm cursor-pointer">
                        </div>
                    @empty
                        <div class="w-full h-40">
                            <p class="w-full text-sm text-gray-500 text-center">No result found.</p>
                        </div>
                    @endforelse
                </div>

                @if (filled($users))
                    {{ $users->links('partials.pagination-link') }}
                @endif
            </form>
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-action-message class="w-full h-full text-center text-red-500 font-bold" on="no-selected">
            {{ __('Failed! Please select a member.') }}
        </x-jet-action-message>

        <x-jet-button class="w-full text-sm bg-blue-500 hover:blue-700" wire:click="save" wire:loading.attr="disabled">
            {{ __('Add Member') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
