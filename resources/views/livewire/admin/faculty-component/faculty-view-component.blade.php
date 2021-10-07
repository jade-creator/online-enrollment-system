<x-table.nested-row>
    <x-slot name="nestedTable">
        <div class="py-4 grid grid-cols-12 gap-2">
            <x-table.column-title class="col-span-2 text-blue-500">ID</x-table.column-title>
            <x-table.column-title class="col-span-3">name</x-table.column-title>
            <x-table.column-title class="col-span-3">role</x-table.column-title>
            <x-table.column-title class="col-span-3">email</x-table.column-title>
            <x-table.column-title class="col-span-1">action</x-table.column-title>
        </div>

        <div class="grid grid-cols-12 gap-2 font-bold text-xs">
            @forelse ($faculty->employees as $employee)
                <div class="pb-3 col-span-12 md:col-span-2 truncate">{{ $employee->custom_id ?? 'N/A' }}</div>
                <div class="pb-3 col-span-12 md:col-span-3 truncate">{{ $employee->user->person->full_name ?? 'N/A' }}</div>
                <div class="pb-3 col-span-12 md:col-span-3 truncate">{{ $employee->user->role->name ?? 'N/A' }}</div>
                <div class="pb-3 col-span-12 md:col-span-3 truncate">{{ $employee->user->email ?? 'N/A' }}</div>
                <x-table.cell-action>
                    @if ($employee->user->id != auth()->user()->id)
                        <a href="{{ 'mailto:'.$employee->user->email }}">
                            <button class="hover:text-indigo-500 mx-1 focus:outline-none" data-toggle="tooltip" data-placement="top" title="Send email">
                                <x-icons.edit-icon/>
                            </button>
                        </a>
                    @endif

                    @can ('leave', $faculty)
                        <button wire:click.prevent="leaveConfirm({{ $employee }})" class="hover:text-red-500 mx-1 focus:outline-none" data-toggle="tooltip" data-placement="top" title="Remove">
                            <x-icons.release-icon/>
                        </button>
                    @endcan

                    @can ('removeMember', $faculty)
                        <button wire:click.prevent="removeMemberConfirm({{ $employee }})" class="hover:text-red-500 mx-1 focus:outline-none" data-toggle="tooltip" data-placement="top" title="Remove">
                            <x-icons.reject-icon/>
                        </button>
                    @endcan
                </x-table.cell-action>
            @empty
                <x-table.no-result>No members under this faculty.🤔</x-table.no-result>
            @endforelse
        </div>
    </x-slot>
</x-table.nested-row>
