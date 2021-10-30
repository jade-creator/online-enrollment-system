<x-table.nested-row>
    <x-slot name="nestedTable">
        <div class="md:hidden grid grid-cols-12 place-items-center py-4 bg-indigo-500">
            <x-table.column-title class="col-span-12"><span class="text-white truncate">Members of {{ $faculty->name ?? 'N/A' }}</span></x-table.column-title>
        </div>
        <div class="py-4 hidden md:grid grid-cols-12 gap-2 px-4 bg-indigo-500">
            <x-table.column-title class="col-span-4"><span class="text-white">member</span></x-table.column-title>
            <x-table.column-title class="col-span-3"><span class="text-white">role</span></x-table.column-title>
            <x-table.column-title class="col-span-4"><span class="text-white">email</span></x-table.column-title>
            <x-table.column-title class="col-span-1"><span class="text-white">action</span></x-table.column-title>
        </div>

        <div class="grid grid-cols-12 md:gap-2 px-4 py-4 md:py-0">
            @forelse ($faculty->employees as $employee)
                <x-table.cell headerLabel="id" class="justify-start md:col-span-4 md:flex items-center">
                    @if ( Laravel\Jetstream\Jetstream::managesProfilePhotos() )
                        <div class="hidden md:block mr-4 flex-shrink-0"><img class="h-8 w-8 rounded-full object-cover" src="{{ $employee->user->profile_photo_url ?? 'N/A' }}"/></div>
                    @endif
                    <div class="flex flex-col my-2 md:my-0">
                        <div>{{ $employee->user->person->full_name ?? 'N/A'}}</div>
                        <div class="font-bold text-gray-400 text-xs pt-0.5">{{ $employee->custom_id ?? 'N/A' }}</div>
                    </div>
                </x-table.cell>
                <x-table.cell headerLabel="role" class="md:col-span-3">{!! $employee->user->role->name_element ?? 'N/A' !!}</x-table.cell>
                <x-table.cell headerLabel="email" class="md:col-span-4">{{ $employee->user->email ?? 'N/A' }}</x-table.cell>
                <x-table.cell-action>
                    @if ($employee->user->id != auth()->user()->id)
                        <button @click.stop class="hover:text-indigo-500 py-4 md:py-0 mx-1 focus:outline-none" data-toggle="tooltip" data-placement="top" title="Send email">
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

                    @can ('removeMember', $faculty)
                        <button wire:click.prevent="removeMemberConfirm({{ $employee }})" @click.stop class="hover:text-red-500 mx-1 focus:outline-none" data-toggle="tooltip" data-placement="top" title="Remove">
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
                <x-table.no-result>No added members yet.🤔</x-table.no-result>
            @endforelse
        </div>
    </x-slot>
</x-table.nested-row>
