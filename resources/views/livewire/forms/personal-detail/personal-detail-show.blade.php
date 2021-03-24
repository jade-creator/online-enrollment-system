<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Personal Details') }}
    </h2>
</x-slot>

<div class="w-full">
    <div class="max-w-5xl mx-auto py-10 sm:px-6 lg:px-8">
        <div>
            @livewire('forms.personal-detail.fullname-form')
            <x-jet-section-border/>
        </div>

         <div class="mt-10 sm:mt-0">
            @livewire('forms.personal-detail.other-info-form')
            <x-jet-section-border/>
        </div>

        <div class="mt-10 sm:mt-0">
            @livewire('forms.personal-detail.contact-form')
            <x-jet-section-border/>
        </div>

        @if (Auth::user()->role->name == 'student')
            <div class="mt-10 sm:mt-0">
                @livewire('forms.personal-detail.guardian-info-form', ['student' => $this->student])   
                <x-jet-section-border/>
            </div>

            <div class="mt-10 sm:mt-0">
                @livewire('forms.personal-detail.education-info-form', ['student' => $this->student])
            </div> 
        @endif

    </div>
</div>
