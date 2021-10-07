<x-jet-dialog-modal wire:model="addingMembers">
    <x-slot name="title">
        {{ __('Faculty Members Maintenance') }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="grid grid-cols-8 gap-6">
                <div class="col-span-8">
                    <input wire:model.debounce.1000ms="search" type="text" placeholder="Search by ID...">
                </div>
                <div class="mt-4 col-span-8 grid grid-cols-12 px-2">
                    <x-table.column-title class="col-span-4">ID</x-table.column-title>
                    <x-table.column-title class="col-span-5">Name</x-table.column-title>
                    <x-table.column-title class="col-span-3">role</x-table.column-title>
                </div>
                <div class="col-span-8">
                    @foreach($users as $user)
                        <div class=" grid grid-cols-12 mt-2">
                            <x-table.cell class="justify-start md:col-span-4">
                                <input wire:model.defer="selected" wire:loading.attr="disabled" value="{{ $user->employee->id }}" type="checkbox" class="mx-2">
                                <span>{{ $user->id ?? 'N/A' }}</span>
                            </x-table.cell>
                            <x-table.cell class="justify-start md:col-span-5">{{ $user->name ?? 'N/A' }}</x-table.cell>
                            <x-table.cell class="justify-start md:col-span-3">{{ $user->role->name ?? 'N/A' }}</x-table.cell>
                        </div>
                    @endforeach
                </div>
                <div class="col-span-8"><x-jet-input-error for="selected" class="mt-2"/></div>
            </div>
        </form>

        <div>
            {{ $users->links('partials.pagination-link') }}
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('addingMembers')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="save" wire:loading.attr="disabled">
            {{ __('Add') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
