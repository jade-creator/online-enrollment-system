<div class="grid grid-cols-12 md:gap-2 px-4 py-4 md:py-0">
    @forelse ($grades as $grade)
        <x-table.cell headerLabel="Code" class="md:col-span-1">{{ $grade->prospectus_subject->subject->code ?? 'N/A' }}</x-table.cell>
        <x-table.cell headerLabel="Title" class="md:col-span-2">{{ $grade->prospectus_subject->subject->title ?? 'N/A' }}</x-table.cell>
        <x-table.cell headerLabel="section" class="md:col-span-2">{{ $registration->section->name ?? 'N/A' }}</x-table.cell>
        <x-table.cell headerLabel="term" class="md:col-span-2">{{ $registration->prospectus->term->term ?? 'N/A' }}</x-table.cell>
        <x-table.cell headerLabel="grade" class="md:col-span-2">{!! $grade->value ?? '<span class="text-gray-400">N/A</span>' !!}</x-table.cell>
        <x-table.cell headerLabel="mark" class="md:col-span-2">{!! $grade->mark->name_element ?? 'N/A' !!}</x-table.cell>
        <x-table.cell-action class="md:col-span-1">
            @can ('update', $grade)
                <x-table.cell-button wire:click.prevent="$emit('modalViewingGrade', {{ $grade }})" @click.stop>
                    <div class="w-full text-center">
                        <x-icons.edit-icon class="hidden md:block"/>
                        <div class="flex justify-center md:hidden">
                            <span>Edit</span>
                            <x-icons.corner-right-up/>
                        </div>
                    </div>
                </x-table.cell-button>
            @elsecan ('view', App\Models\Grade::class)
                <x-table.cell-button>
                    <div class="w-full text-center">
                        <x-icons.lock-icon/>
                    </div>
                </x-table.cell-button>
            @endcan
        </x-table.cell-action>
    @empty
        <x-table.no-result>No enrolled subjects.🤔</x-table.no-result>
    @endforelse
</div>
