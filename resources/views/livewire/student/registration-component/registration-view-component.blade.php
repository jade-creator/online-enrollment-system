<div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
    @if (isset($registration))
        <div class="py-10">
            <div class="flex items-center justify-between">
                <p class="font-bold text-lg"><span>{{ $registration->student->user->person->full_name ?? 'N/A' }} </span>- Pre Registration</p>
                <x-jet-button wire:click.prevent="createPDF" wire:loading.attr="disabled" class="bg-indigo-700 hover:bg-indigo-800 flex items-end">
                    <x-icons.export-icon/>
                    <span>{{ __('Export as PDF')}}</span>
                </x-jet-button>
            </div>
            <x-jet-section-border/>
        </div>

        {{-- PRE-REGISTRATION INFO    --}}
        <x-jet-form-section submit="">
            <x-slot name="title">
                <div class="w-full text-sm font-semibold flex items-center justify-between">
                    <p>Pre Registration Info</p>
                    <p class="font-normal text-xs">{{ $registration->created_at->format('F j, Y') }}</p>
                </div>
            </x-slot>

            <x-slot name="description"></x-slot>

            <x-slot name="form">
                <form>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Registration ID:') }}"/>
                        <x-jet-input type="text" class="mt-1 block w-full" value="{{ $registration->id ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Status:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->status->name ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Program:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->prospectus->program->code ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Level:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->prospectus->level->level ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Term:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->prospectus->term->term ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('School Year:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->school_year ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Section:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->section->name ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Total Unit:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $totalUnit ?? 'N/A' }}" readonly/>
                    </div>
                </form>
            </x-slot>

            <x-slot name="actions"></x-slot>
        </x-jet-form-section>
        <x-jet-section-border/>

        {{-- STUDENT DETAILS    --}}
        <x-jet-form-section submit="">
            <x-slot name="title">
                <div class="w-full text-sm font-semibold flex items-center justify-between">
                    <p>Student Details</p>
                </div>
            </x-slot>

            <x-slot name="description"></x-slot>

            <x-slot name="form">
                <form>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Student ID:') }}"/>
                        <x-jet-input type="text" class="mt-1 block w-full" value="{{ $registration->student->custom_id ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Type:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->is_new ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Name:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->full_name ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Email:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->email ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Mobile Number:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->contact->mobile_number ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Address:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->contact->address ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Birthdate:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ \Carbon\Carbon::parse($registration->student->user->person->detail->birthdate)->format('F j, Y') ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Birthplace:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->detail->birthplace ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Gender:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->detail->gender ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Civil Status:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->detail->civil_status ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Religion:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->detail->civil_status ?? 'N/A' }}" readonly/>
                    </div>
                    <div class="col-span-3">
                        <x-jet-label value="{{ __('Nationality:') }}"/>
                        <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->detail->country->name ?? 'N/A' }}" readonly/>
                    </div>
                </form>
            </x-slot>

            <x-slot name="actions"></x-slot>
        </x-jet-form-section>
        <x-jet-section-border/>

        {{-- DISPLAY LIST OF COURSES/SCHEDULE OF CURRENT TERM  --}}
        <livewire:student.schedule-component.schedule-index-component :registration="$registration" key="{{ 'student-schedule-index-component-'.now() }}"/>

            {{-- DISPLAY ONLY FOR EXTENDED REGISTRATION/IRREGULAR STUDENT'S REGISTRATION --}}
            @forelse ($registration->extensions as $index => $extension)
                <livewire:student.schedule-component.schedule-index-component :registration="$extension->registration" key="{{ 'student-schedule-index-component-'.$index.'-'.now() }}"/>
            @empty
                {{-- DISPLAY NOTHING IF NOT EXTENDED/REGULAR STUDENT'S REGISTRATION --}}
            @endforelse

        {{-- ASSESSMENT OF FEES --}}
        <livewire:student.assessment-component.assessment-index-component :registration="$registration" :totalUnit="$totalUnit" key="{{ 'student-assessment-index-component'.now() }}"/>

        {{--Main action buttons: submit,confirm,enroll,pending,reject--}}
        <livewire:partials.registration-form-buttons :registration="$registration" key="{{ 'registration-form-buttons-'.now() }}">

        {{--Modal form: selecting section and apply schedules--}}
        <livewire:partials.select-section-form key="{{ 'select-section-form-'.now() }}">
    @endif

    <div wire:loading>
        @include('partials.loading')
    </div>
</div>
