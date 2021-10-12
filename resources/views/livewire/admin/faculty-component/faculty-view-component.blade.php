<x-table.nested-row>
    <x-slot name="nestedTable">
        <div class="md:hidden grid grid-cols-12 place-items-center py-4 bg-indigo-500">
            <x-table.column-title class="col-span-12"><span class="text-white truncate">Members of {{ $faculty->name ?? 'N/A' }}</span></x-table.column-title>
        </div>
        <div class="py-4 hidden md:grid grid-cols-12 gap-2 px-4 bg-indigo-500">
            <x-table.column-title class="col-span-2"><span class="text-white">ID</span></x-table.column-title>
            <x-table.column-title class="col-span-3"><span class="text-white">name</span></x-table.column-title>
            <x-table.column-title class="col-span-2"><span class="text-white">role</span></x-table.column-title>
            <x-table.column-title class="col-span-3"><span class="text-white">email</span></x-table.column-title>
            <x-table.column-title class="col-span-2"><span class="text-white">action</span></x-table.column-title>
        </div>

        <div class="grid grid-cols-12 md:gap-2 px-4 py-4 md:py-0">
            @forelse ($faculty->employees as $employee)
                <x-table.cell headerLabel="id" class="md:col-span-2">{{ $employee->custom_id ?? 'N/A' }}</x-table.cell>
                <x-table.cell headerLabel="name" class="md:col-span-3">{{ $employee->user->person->full_name ?? 'N/A' }}</x-table.cell>
                <x-table.cell headerLabel="role" class="md:col-span-2">{{ $employee->user->role->name ?? 'N/A' }}</x-table.cell>
                <x-table.cell headerLabel="email" class="md:col-span-3">{{ $$employee->user->email ?? 'N/A' }}</x-table.cell>
                <x-table.cell-action>
                    @if ($employee->user->id != auth()->user()->id)
                        <button class="hover:text-indigo-500 py-4 md:py-0 mx-1 focus:outline-none" data-toggle="tooltip" data-placement="top" title="Send email">
                            <a href="{{ 'mailto:'.$employee->user->email }}">
                                <div class="w-full text-center">
                                    <x-icons.email-icon class="hidden md:block"/>
                                    <div class="flex justify-center md:hidden">
                                        <span class="">Send email</span>
                                        <x-icons.corner-right-up />
                                    </div>
                                </div>
                            </a>
                        </button>
                    @endif

                    @can ('leave', $faculty)
                        <button wire:click.prevent="leaveConfirm({{ $employee }})" class="hover:text-red-500 mx-1 focus:outline-none" data-toggle="tooltip" data-placement="top" title="Remove">
                            <x-icons.release-icon/>
                        </button>
                    @endcan

                    @can ('removeMember', $faculty)
                        <button wire:click.prevent="removeMemberConfirm({{ $employee }})" class="hover:text-red-500 mx-1 focus:outline-none" data-toggle="tooltip" data-placement="top" title="Remove">
                            <div class="w-full text-center">
                                <x-icons.reject-icon class="hidden md:block"/>
                                <div class="flex justify-center md:hidden">
                                    <span>Remove</span>
                                    <x-icons.corner-right-up />
                                </div>
                            </div>
                        </button>
                    @endcan
                </x-table.cell-action>
            @empty
                <x-table.no-result>No added classes yet.🤔</x-table.no-result>
            @endforelse
        </div>
    </x-slot>
</x-table.nested-row>
