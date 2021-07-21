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
            <p class="font-normal text-xs">{{ Carbon\Carbon::parse($registration->created_at)->format('F j, Y') }}</p>
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
                        <td class="pb-4">Level: <span class="text-gray-500 pl-4">{{ $registration->prospectus->level->level ?? 'N/A' }}</span></td>
                        <td class="pb-4">Program: <span class="text-gray-500 pl-4">{{ $registration->prospectus->program->code ?? 'N/A'  }}</span></td>
                    </tr>
                    <tr>
                        <td class="pb-4">Track: <span class="text-gray-500 pl-4">{{ $registration->prospectus->strand->track->track ?? 'N/A' }}</span></td>
                        <td class="pb-4">Strand: <span class="text-gray-500 pl-4">{{ $registration->prospectus->strand->code ?? 'N/A'  }}</span></td>
                    </tr>
                    <tr>
                        <td class="pb-4">Term: <span class="text-gray-500 pl-4">{{ $registration->prospectus->term->term ?? 'N/A' }}</span></td>
                        <td class="pb-4">School Year: <span class="text-gray-500 pl-4">{{ Carbon\Carbon::parse($registration->created_at)->format('Y') .' - '. Carbon\Carbon::parse($registration->created_at)->addYear()->format('Y') }}</span></td>
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
                        <td class="pb-4">Type: <span class="text-gray-500 pl-4">{{ $registration->isNew ? 'New' : 'Old' }}</span></td>
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
                        <td class="pb-4">Birthdate: <span class="text-gray-500 pl-4">{{ Carbon\Carbon::parse($registration->student->user->person->detail->birthdate)->format('F j, Y') ?? 'N/A' }}</span></td>
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
            <p class="font-normal text-xs">Total Units: {{ $registration->grades->sum('subject.unit') }}</p>
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
                            <td class="pb-4 text-center">{{ $grade->subject->id ?? 'N/A' }}</td>
                            <td class="pb-4 text-center">{{ $grade->subject->code ?? 'N/A' }}</td>
                            <td class="pb-4 text-center">{{ $grade->subject->title ?? 'N/A' }}</td>
                            <td class="pb-4 text-center">{{ $grade->subject->unit ?? 'N/A' }}</td>
                            <td class="pb-4 text-center">
                                @forelse ($grade->subject->requisites as $requisite)
                                    {{ $loop->first ? '' : ', '  }}
                                    <span>&nbsp;{{ $requisite->code }}</span>
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

    <div class="w-full mb-10">
        <div class="w-full bg-blue-100 bg-opacity-20 border-t border-l border-r border-blue-200 p-4 rounded-t-md font-semibold flex items-center justify-between">
            <p>Assessment</p>
            <p class="font-normal text-xs">Total: PHP {{ number_format((float)$registration->prospectus->fees->sum('price'), 2, '.', ',') }}</p>
        </div>
        <div class="border-b border-l border-r border-gray-200 rounded-b-md p-4">
            <table class="w-full">
                <thead>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    @forelse ($registration->prospectus->fees as $fee)
                        <tr>
                            <td class="pb-4 text-left font-bold">{{ $fee->name ?? 'N/A' }}</td>
                            <td class="pb-4 text-left">PHP {{ number_format((float)$fee->price, 2, '.', ',') ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td rowspan="2">No Payment Found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="w-full mb-10 flex items-center justify-start">
        @can('update', $registration)
            @if ($registration->status->name == 'pending')
                <x-jet-button wire:click.prevent="$toggle('enrollingStudent')" wire:loading.attr="disabled" class="ml-2 bg-indigo-500 hover:bg-indigo-700 flex items-end">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="12" cy="9" r="6"></circle>
                        <polyline points="9 14.2 9 21 12 19 15 21 15 14.2" transform="rotate(-30 12 9)"></polyline>
                        <polyline points="9 14.2 9 21 12 19 15 21 15 14.2" transform="rotate(30 12 9)"></polyline>
                     </svg>
                    <span>{{ __('Enroll') }}</span>
                </x-jet-button>
            @else
                <x-jet-button wire:click.prevent="pending" wire:loading.attr="disabled" class="ml-2 bg-yellow-500 hover:bg-yellow-700 flex items-end">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M15 4.55a8 8 0 0 0 -6 14.9m0 -4.45v5h-5"></path>
                        <line x1="18.37" y1="7.16" x2="18.37" y2="7.17"></line>
                        <line x1="13" y1="19.94" x2="13" y2="19.95"></line>
                        <line x1="16.84" y1="18.37" x2="16.84" y2="18.38"></line>
                        <line x1="19.37" y1="15.1" x2="19.37" y2="15.11"></line>
                        <line x1="19.94" y1="11" x2="19.94" y2="11.01"></line>
                     </svg>
                    <span>{{ __('Pending') }}</span>
                </x-jet-button>
            @endif
            <x-jet-button wire:click.prevent="rejectConfirm" wire:loading.attr="disabled" class="ml-2 bg-red-500 hover:bg-red-700 flex items-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="12" cy="12" r="9"></circle>
                    <line x1="5.7" y1="5.7" x2="18.3" y2="18.3"></line>
                 </svg>
                <span>{{ __('Reject') }}</span>
            </x-jet-button>
        @endcan
    </div>

    <div wire:loading wire:target="enroll, pending, rejectConfirm, enrollingStudent, createPDF">
        @include('partials.loading')
    </div>

    <!-- Export User/s Confirmation Modal -->
    <x-jet-dialog-modal wire:model="enrollingStudent" maxWidth="sm">
        <x-slot name="title">
            {{ __('Enroll Student') }}
        </x-slot>

        <x-slot name="content">
            <form>
                <div class="col-span-6 mb-2">
                    <x-jet-label for="student_id" value="{{ __('Auto Generated Student ID') }}" class="my-2" />
                    <input wire:model="studentId" readonly type="text" id="student_id" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                </div>

                <div class="col-span-6">
                    <x-jet-label for="student_type" value="{{ __('Section') }}" class="my-2"/>
                    <select wire:model="registration.section_id" wire:loading.attr="disabled" id="student_type" class="w-full flex-1 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        @forelse ($this->sections as $section)
                            @if ($loop->first)
                                <option value="" selected>-- choose a section --</option>
                            @endif
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @empty
                            <option value="">No records found</option>
                        @endforelse
                    </select> 
                    <x-jet-input-error for="registration.section_id" class="mt-2"/>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('enrollingStudent')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="enroll" wire:loading.attr="disabled">
                {{ __('Submit') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
