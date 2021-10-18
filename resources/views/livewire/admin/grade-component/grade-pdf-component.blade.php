<div class="max-w-5xl mx-auto sm:px-6 px-4 md:px-8">
    @if (isset($registration))
        <div class="py-10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-bold text-lg"><span class="capitalize">{{ $registration->student->user->person->full_name ?? 'N/A' }}</span> - Grade Report</p>
                    <a href="{{ route('pre.registration.view', $registration->id) }}" title="View Details">
                        <p class="text-indigo-500 font-bold hover:underline text-sm">REGISTRATION ID: <span>{{ $registration->custom_id ?? 'N/A' }}</span></p>
                    </a>
                </div>
                <x-jet-button wire:click="createPdf" wire:loading.attr="disabled" class="bg-indigo-700 hover:bg-indigo-800 flex items-end">
                    <x-icons.export-icon/>
                    <span>{{ __('Export as PDF')}}</span>
                </x-jet-button>
            </div>
            <x-jet-section-border/>
        </div>
        <div x-data="{ open: true }">
            <x-table.nested-row>
                <x-slot name="nestedTable">
                    <div class="md:hidden grid grid-cols-12 place-items-center py-4 bg-indigo-500">
                        <x-table.column-title class="col-span-12"><span class="text-white">Grade</span></x-table.column-title>
                    </div>
                    <div class="py-4 hidden md:grid grid-cols-12 gap-2 px-4 bg-indigo-500">
                        <x-table.column-title class="col-span-2"><span class="text-white">code</span></x-table.column-title>
                        <x-table.column-title class="col-span-3"><span class="text-white">title</span></x-table.column-title>
                        <x-table.column-title class="col-span-3"><span class="text-white">section</span></x-table.column-title>
                        <x-table.column-title class="col-span-2"><span class="text-white">grade</span></x-table.column-title>
                        <x-table.column-title class="col-span-2"><span class="text-white">mark</span></x-table.column-title>
                    </div>

                    <div class="grid grid-cols-12 md:gap-2 px-4 py-4 md:py-0">
                        @forelse ($registration->grades as $grade)
                            <x-table.cell headerLabel="Subject" class="md:col-span-2">{{ $grade->prospectus_subject->subject->code ?? 'N/A' }}</x-table.cell>
                            <x-table.cell headerLabel="Title" class="md:col-span-3">{{ $grade->prospectus_subject->subject->title ?? 'N/A' }}</x-table.cell>
                            <x-table.cell headerLabel="Professor" class="md:col-span-3">{{ $registration->section->name ?? 'N/A' }}</x-table.cell>
                            <x-table.cell headerLabel="Day" class="md:col-span-2">{{ $grade->value ?? 'N/A' }}</x-table.cell>
                            <x-table.cell headerLabel="Start Time" class="md:col-span-2">{{ $grade->mark->name ?? 'N/A' }}</x-table.cell>
                        @empty
                            <x-table.no-result>No added classes yet.🤔</x-table.no-result>
                        @endforelse
                    </div>
                </x-slot>
            </x-table.nested-row>
        </div>
        <p>Computed Grade: <span>{{ number_format($this->grade, '2', '.', '') ?? 'N/A' }}</span></p>
    @endisset
</div>
