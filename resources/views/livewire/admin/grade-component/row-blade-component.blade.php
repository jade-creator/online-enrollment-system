<div class="grid grid-cols-12 md:gap-2">
    @forelse ($grades as $grade)
        <x-table.cell headerLabel="Subject" class="md:col-span-2">{{ $grade->prospectus_subject->subject->code ?? 'N/A' }}</x-table.cell>
        <x-table.cell headerLabel="Title" class="md:col-span-2">{{ $grade->prospectus_subject->subject->title ?? 'N/A' }}</x-table.cell>
        <x-table.cell headerLabel="Professor" class="md:col-span-2">{{ $registration->section->name ?? 'N/A' }}</x-table.cell>
        <x-table.cell headerLabel="Day" class="md:col-span-2">{{ $registration->prospectus->term->term ?? 'N/A' }}</x-table.cell>
        <x-table.cell headerLabel="Start Time" class="md:col-span-2">{{ $grade->value ?? 'N/A' }}</x-table.cell>
        <x-table.cell headerLabel="End Time" class="md:col-span-1">{{ $grade->mark->name ?? 'N/A' }}</x-table.cell>
        <x-table.cell-action>
            @can ('update', $grade)
                <x-table.cell-button wire:click.prevent="$emit('modalViewingGrade', {{ $grade }})">
                    <div class="w-full text-center">
                        <x-icons.edit-icon class="hidden md:block"/>
                        <div class="flex justify-center md:hidden">
                            <span>Edit</span>
                            <x-icons.edit-icon/>
                        </div>
                    </div>
                </x-table.cell-button>
            @elsecan ('view', App\Models\Grade::class)
                <x-table.cell-button>
                    <x-icons.lock-icon/>
                </x-table.cell-button>
            @endcan
        </x-table.cell-action>
    @empty
        <x-table.no-result>No enrolled subjects.🤔</x-table.no-result>
    @endforelse
</div>