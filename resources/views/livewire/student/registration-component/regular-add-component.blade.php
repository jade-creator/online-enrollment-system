<div class="max-w-5xl mx-auto p-4 md:p-8">
    @include('partials.view-profile-button')

    <div class="w-full pl-0 md:pl-8">
        <x-jet-form-section submit="">
            <x-slot name="title">
                {{ __('Pre Registration') }}
            </x-slot>

            <x-slot name="description">
                {{ 'Hi Student! Welcome to the Pre-Registration Page. Please fill out these form accordingly.' }}
            </x-slot>

            <x-slot name="form">
                <x-jet-label class="font-bold text-indigo-500 text-xs" for="subjects" value="{{ __('Subjects') }}" />
                <div class="col-span-6 -mt-4" id="subjects">
                    <x-table.main>
                        <x-slot name="filter"></x-slot>
                        <x-slot name="paginationLink"></x-slot>

                        <x-slot name="head">
                            <x-table.column-title class="col-span-2">code</x-table.column-title>
                            <x-table.column-title class="col-span-3">title</x-table.column-title>
                            <x-table.column-title class="col-span-1">unit</x-table.column-title>
                            <x-table.column-title class="col-span-3">co requisite</x-table.column-title>
                            <x-table.column-title class="col-span-3">pre requisite</x-table.column-title>
                        </x-slot>

                        <x-slot name="body">
                            @forelse ($subjects as $index => $prospectus_subject)
                                <div wire:key="table-row-{{$prospectus_subject->subject->code}}">
                                    <x-table.row>
                                        <div name="slot" class="grid grid-cols-12 md:gap-2">
                                            <x-table.cell headerLabel="Code" class="justify-start md:col-span-2">{{ $prospectus_subject->subject->code ?? 'N/A' }}</x-table.cell>
                                            <x-table.cell headerLabel="title" class="justify-start md:col-span-3" title="{{ $prospectus_subject->subject->title ?? 'N/A' }}">{{ $prospectus_subject->subject->title ?? 'N/A' }}</x-table.cell>
                                            <x-table.cell headerLabel="unit" class="justify-start md:col-span-1">{{ $prospectus_subject->unit ?? 'N/A' }}</x-table.cell>
                                            <x-table.cell headerLabel="co requisite" class="justify-start md:col-span-3">
                                            @forelse ($prospectus_subject->corequisites as $requisite)
                                                {{ $loop->first ? '' : ', '  }}
                                                <span>&nbsp;{{ $requisite->code }}</span>
                                            @empty
                                                {!! '<span class="text-gray-400">N/A</span>' !!}
                                            @endforelse
                                            </x-table.cell>
                                            <x-table.cell headerLabel="pre requisite" class="justify-start md:col-span-3">
                                            @forelse ($prospectus_subject->prerequisites as $requisite)
                                                {{ $loop->first ? '' : ', '  }}
                                                <span>&nbsp;{{ $requisite->code }}</span>
                                            @empty
                                                {!! '<span class="text-gray-400">N/A</span>' !!}
                                                @endforelse
                                            </x-table.cell>
                                        </div>
                                    </x-table.row>
                                </div>
                            @empty
                                <x-table.no-result>No subjects found.🤔</x-table.no-result>
                            @endforelse
                        </x-slot>
                    </x-table.main>
                </div>

            </x-slot>

            <x-slot name="actions">
                <a href="{{ route('student.registrations.create') }}">
                    <x-jet-secondary-button class="hover:bg-indigo-100" wire:loading.attr="disabled">
                        {{ __('Go Back') }}
                    </x-jet-secondary-button>
                </a>

                @can ('register', $prospectus)
                    <x-jet-button wire:click.prevent="save"  class="ml-2 bg-indigo-700 hover:bg-indigo-800" wire:loading.attr="disabled">
                        {{ __('Register') }}
                    </x-jet-button>
                @endcan
            </x-slot>
        </x-jet-form-section>
        <x-jet-section-border/>
    </div>

    @if (session()->has('alert'))
        <x-form.alert type="{{session('alert')['type']}}">{!!session()->pull('alert')['message']!!}</x-form.alert>
    @endif

    @push('scripts')
        <script src="{{ asset('js/alert.js') }}"></script>
    @endpush
</div>
