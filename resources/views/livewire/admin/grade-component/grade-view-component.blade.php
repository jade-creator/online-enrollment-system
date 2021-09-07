<x-table.nested-row>
    <x-slot name="nestedTable">
        <div class="py-4 grid grid-cols-12 gap-2">
            <x-table.column-title class="col-span-2 text-blue-500">subject</x-table.column-title>
            <x-table.column-title class="col-span-4">title</x-table.column-title>
            <x-table.column-title class="col-span-2">grade</x-table.column-title>
            <x-table.column-title class="col-span-3">remark</x-table.column-title>
            <x-table.column-title class="col-span-1">action</x-table.column-title>
        </div>

        <div class="grid grid-cols-12 gap-2">
            @forelse ($registration->grades as $grade)
                <div class="pb-3 col-span-12 md:col-span-2 font-bold text-xs">
                    <p class="truncate">{{ $grade->prospectus_subject->subject->code ?? 'N/A' }}</p>
                </div>
                <div class="pb-3 col-span-12 md:col-span-4 font-bold text-xs">
                    <p class="truncate">{{ $grade->prospectus_subject->subject->title ?? 'N/A' }}</p>
                </div>
                <div class="col-span-12 md:col-span-2 font-bold text-xs">
                    <p class="truncate">
                        {{ $grade->value ?? 'N/A' }}
                    </p>
                </div>
                <div class="col-span-12 md:col-span-3 font-bold text-xs">
                    <p class="truncate">
                        {{ $grade->mark->name ?? 'N/A' }}
                    </p>
                </div>
                <x-table.cell-action>
                    @can ('update', $registration)
                        <button wire:click.prevent="$emit('modalViewingGrade', {{ $grade }})" class="hover:text-indigo-500 rounded-circle p-1 mx-1 focus:outline-none" data-toggle="tooltip" data-placement="top" title="Edit">
                            <x-icons.edit-icon/>
                        </button>
                    @elsecan ('view', App\Models\Grade::class)
                        <x-table.cell-button>
                            <x-icons.lock-icon/>
                        </x-table.cell-button>
                    @endcan
                </x-table.cell-action>
            @empty
                <x-table.no-result>No added subject under the prospectus.🤔</x-table.no-result>
            @endforelse
        </div>
    </x-slot>
</x-table.nested-row>
