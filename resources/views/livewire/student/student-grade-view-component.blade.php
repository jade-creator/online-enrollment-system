<div class="w-full">
    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Prospectus">
            <a href="{{ route('student.registrations.create') }}">
                <x-table.nav-button>
                    Create New Registration
                </x-table.nav-button>
            </a>
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <div class="flex items-center justify-between">
                    @isset ($prospectus)
                        <p class="flex items-center justify-between text-indigo-500">
                            <span>{{ $prospectus->program->code ?? 'N/A' }}</span>
                            <x-icons.right-arrow-icon/>
                            <span>{{ $prospectus->level->level ?? 'N/A' }}</span>
                            <x-icons.right-arrow-icon/>
                            <span>{{ $prospectus->term->term ?? 'N/A' }}</span>
                        </p>
                    @endisset
                    <x-table.filter :isSearchable="false" :isFilterable="false">
                        <livewire:partials.prospectus-dropdown/>
                    </x-table.filter>
                </div>
            </x-slot>

            <x-slot name="paginationLink"></x-slot>

            <x-slot name="head">
                <x-table.column-title class="col-span-1">code</x-table.column-title>
                <x-table.column-title class="col-span-2">title</x-table.column-title>
                <x-table.column-title class="col-span-2">description</x-table.column-title>
                <x-table.column-title class="col-span-2">co-requisite</x-table.column-title>
                <x-table.column-title class="col-span-2">pre-requisite</x-table.column-title>
                <x-table.column-title class="col-span-1">unit</x-table.column-title>
                <x-table.column-title class="col-span-1">remark</x-table.column-title>
                <x-table.column-title class="col-span-1">grade</x-table.column-title>
            </x-slot>

            <x-slot name="body">
                @forelse ($prospectusSubjects as $index => $prospectus_subject)
                    <x-table.row>
                        <div name="slot" class="grid grid-cols-12 md:gap-2">
                            <x-table.cell headerLabel="Code" class="justify-start md:col-span-1">{{ $prospectus_subject->subject->code ?? 'N/A' }}</x-table.cell>
                            <x-table.cell headerLabel="Title" class="justify-start md:col-span-2" title="{{ $prospectus_subject->subject->title ?? 'N/A' }}">{{ $prospectus_subject->subject->title ?? 'N/A' }}</x-table.cell>
                            <x-table.cell headerLabel="Unit" class="justify-start md:col-span-2" title="{{ $prospectus_subject->subject->description ?? 'N/A' }}">{{ $prospectus_subject->subject->description ?? 'N/A' }}</x-table.cell>
                            <x-table.cell headerLabel="Co-requisite" class="justify-start md:col-span-2">
                                @forelse ($prospectus_subject->corequisites as $subject)
                                    {{ $loop->first ? '' : ', '  }}
                                    <a href="{{ route('admin.subjects.view', ['search' => $subject->title]) }}" class="text-indigo-500 underline">{{ $subject->code }}</a>
                                @empty
                                    N/A
                                @endforelse
                            </x-table.cell>
                            <x-table.cell headerLabel="Pre-requisite" class="justify-start md:col-span-2">
                                @forelse ($prospectus_subject->prerequisites as $subject)
                                    {{ $loop->first ? '' : ', '  }}
                                    <a href="{{ route('admin.subjects.view', ['search' => $subject->title]) }}" class="text-indigo-500 underline">{{ $subject->code }}</a>
                                @empty
                                    N/A
                                @endforelse
                            </x-table.cell>
                            <x-table.cell headerLabel="Unit" class="justify-start md:col-span-1">{{ $prospectus_subject->unit ?? 'N/A' }}</x-table.cell>
                            <x-table.cell headerLabel="Remark" class="justify-start md:col-span-1">{{
                                array_key_exists($prospectus_subject->id, $grades) && array_key_exists('mark', $grades[$prospectus_subject->id])
                                    ? $grades[$prospectus_subject->id]['mark'] ?? 'N/A' : 'N/A'
                            }}</x-table.cell>
                            <x-table.cell headerLabel="Remark" class="justify-start md:col-span-1">{{
                                array_key_exists($prospectus_subject->id, $grades) && array_key_exists('value', $grades[$prospectus_subject->id])
                                    ? $grades[$prospectus_subject->id]['value'] ?? 'N/A' : 'N/A'
                            }}</x-table.cell>
                        </div>
                    </x-table.row>
                @empty
                    <x-table.no-result>No subjects found.🤔</x-table.no-result>
                @endforelse
            </x-slot>
        </x-table.main>
    </div>

    <div>@include('partials.loading')</div>
</div>
