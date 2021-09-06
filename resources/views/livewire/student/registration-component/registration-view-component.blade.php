<div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
    <div class="py-10">
        <div class="flex items-center justify-between">
            <p class="font-bold text-lg">Pre Registration</p>
            <x-jet-button wire:click.prevent="createPDF" wire:loading.attr="disabled" class="ml-2 bg-indigo-700 hover:bg-indigo-800 flex items-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                    <path d="M5 8v-3a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-5"></path>
                    <circle cx="6" cy="14" r="3"></circle>
                    <path d="M4.5 17l-1.5 5l3 -1.5l3 1.5l-1.5 -5"></path>
                </svg>
                <span>{{ __('Export to PDF')}}</span>
            </x-jet-button>
        </div>
        <x-jet-section-border/>
    </div>

    <div class="w-full mb-10">
        <div class="w-full bg-blue-100 bg-opacity-20 border-t border-l border-r border-blue-200 p-4 rounded-t-md font-semibold flex items-center justify-between">
            <p>Pre Registration Info</p>
            <p class="font-normal text-xs">{{ $registration->created_at->format('F j, Y') }}</p>
        </div>
        <div class="border-b border-l border-r border-gray-200 rounded-b-md p-4">
            <table class="w-full">
                <thead>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                <tr>
                    <td class="pb-4">Registration ID: <span class="text-gray-500 pl-4">{{ $registration->id ?? 'N/A' }}</span></td>
                    <td class="pb-4">Status: <span class="text-gray-500 pl-4">{{ $registration->status->name ?? 'N/A'  }}</span></td>
                </tr>
                <tr>
                    <td class="pb-4">Program: <span class="text-gray-500 pl-4">{{ $registration->prospectus->program->code ?? 'N/A'  }}</span></td>
                    <td class="pb-4">Level: <span class="text-gray-500 pl-4">{{ $registration->prospectus->level->level ?? 'N/A' }}</span></td>
                </tr>
                <tr>
                    <td class="pb-4">Term: <span class="text-gray-500 pl-4">{{ $registration->prospectus->term->term ?? 'N/A' }}</span></td>
                    <td class="pb-4">School Year: <span class="text-gray-500 pl-4">{{ $registration->school_year ?? 'N/A' }}</span></td>
                </tr>
                <tr>
                    <td class="pb-4">Section: <span class="text-gray-500 pl-4">{{ $registration->section->name ?? 'N/A' }}</span></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="w-full mb-10">
        <div class="w-full bg-blue-100 bg-opacity-20 border-t border-l border-r border-blue-200 p-4 rounded-t-md font-semibold">
            <p>Student Details</p>
        </div>
        <div class="border-b border-l border-r border-gray-200 rounded-b-md p-4">
            <table class="w-full">
                <thead>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                <tr>
                    <td class="pb-4">Student ID: <span class="text-gray-500 pl-4">{{ $registration->student->isStudent ? $registration->student->custom_id : 'N/A' }}</span></td>
                    <td class="pb-4">Type: <span class="text-gray-500 pl-4">{{ $registration->is_new ?? 'N/A' }}</span></td>
                </tr>
                <tr>
                    <td class="pb-4">Name: <span class="text-gray-500 pl-4">{{ $registration->student->user->person->full_name ?? 'N/A' }}</span></td>
                    <td class="pb-4">Email: <span class="text-gray-500 pl-4">{{ $registration->student->user->email ?? 'N/A'  }}</span></td>
                </tr>
                <tr>
                    <td class="pb-4">Mobile Number: <span class="text-gray-500 pl-4">{{ $registration->student->user->person->contact->mobile_number ?? 'N/A' }}</span></td>
                    <td class="pb-4">Address: <span class="text-gray-500 pl-4">{{ $registration->student->user->person->contact->address ?? 'N/A'  }}</span></td>
                </tr>
                <tr>
                    <td class="pb-4">Birthdate: <span class="text-gray-500 pl-4">{{ $registration->student->user->person->detail->birthdate->format('F j, Y') ?? 'N/A' }}</span></td>
                    <td class="pb-4">Birthplace: <span class="text-gray-500 pl-4">{{ $registration->student->user->person->detail->birthplace ?? 'N/A'  }}</span></td>
                </tr>
                <tr>
                    <td class="pb-4">Gender: <span class="text-gray-500 pl-4">{{ $registration->student->user->person->detail->gender ?? 'N/A' }}</span></td>
                    <td class="pb-4">Civil Status: <span class="text-gray-500 pl-4">{{ $registration->student->user->person->detail->civil_status ?? 'N/A'  }}</span></td>
                </tr>
                <tr>
                    <td class="pb-4">Religion: <span class="text-gray-500 pl-4">{{ $registration->student->user->person->detail->religion ?? 'N/A' }}</span></td>
                    <td class="pb-4">Nationality: <span class="text-gray-500 pl-4">{{ $registration->student->user->person->detail->country->name ?? 'N/A'  }}</span></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="w-full mb-10">
        <div class="w-full bg-blue-100 bg-opacity-20 border-t border-l border-r border-blue-200 p-4 rounded-t-md font-semibold flex items-center justify-between">
            <p>Subjects</p>
            <p class="font-normal text-xs">Total Units: {{ $registration->grades->sum('prospectus_subject.unit') }}</p>
        </div>
        <div class="border-b border-l border-r border-gray-200 rounded-b-md p-4">
            <table class="w-full">
                <thead>
                <th>ID</th>
                <th>Code</th>
                <th>Title</th>
                <th>Unit</th>
                <th>Pre Requisite</th>
                </thead>
                <tbody>
                @forelse ($registration->grades as $grade)
                    <tr>
                        <td class="pb-4 text-center">{{ $grade->prospectus_subject->subject->id ?? 'N/A' }}</td>
                        <td class="pb-4 text-center">{{ $grade->prospectus_subject->subject->code ?? 'N/A' }}</td>
                        <td class="pb-4 text-center">{{ $grade->prospectus_subject->subject->title ?? 'N/A' }}</td>
                        <td class="pb-4 text-center">{{ $grade->prospectus_subject->unit ?? 'N/A' }}</td>
                        <td class="pb-4 text-center">
                            @forelse ($grade->prospectus_subject->prerequisites as $requisite)
                                {{ $loop->first ? '' : ', '  }}
                                <span>{{ $requisite->code }}</span>
                            @empty
                            @endforelse
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td rowspan="4">No Subject Found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

{{--    <div class="w-full mb-10"> TODO: fee module--}}
{{--        <div class="w-full bg-blue-100 bg-opacity-20 border-t border-l border-r border-blue-200 p-4 rounded-t-md font-semibold flex items-center justify-between">--}}
{{--            <p>Assessment</p>--}}
{{--            <p class="font-normal text-xs">Total: PHP {{ number_format((float)$registration->prospectus->fees->sum('price'), 2, '.', ',') }}</p>--}}
{{--        </div>--}}
{{--        <div class="border-b border-l border-r border-gray-200 rounded-b-md p-4">--}}
{{--            <table class="w-full">--}}
{{--                <thead>--}}
{{--                <th></th>--}}
{{--                <th></th>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @forelse ($registration->prospectus->fees as $fee)--}}
{{--                    <tr>--}}
{{--                        <td class="pb-4 text-left font-bold">{{ $fee->name ?? 'N/A' }}</td>--}}
{{--                        <td class="pb-4 text-left">PHP {{ number_format((float)$fee->price, 2, '.', ',') ?? 'N/A' }}</td>--}}
{{--                    </tr>--}}
{{--                @empty--}}
{{--                    <tr>--}}
{{--                        <td rowspan="2">No Payment Found.</td>--}}
{{--                    </tr>--}}
{{--                @endforelse--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--    </div>--}}

    <livewire:partials.registration-form-buttons :registration="$registration" key="{{ 'registration-form-buttons-'.now() }}">

    <div wire:loading>
        @include('partials.loading')
    </div>
</div>
