<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Information') }}
        </h2>
    </x-slot>

    <div class="w-full flex flex-col md:flex-row max-w-5xl mx-auto p-4 sm:px-6 lg:px-8">
        @livewire('partials.progress-form')
        <div class="w-full py-10 sm:px-6 lg:px-8">
            <div class="pb-4">
                <p>Welcome 🎉! This is the <span class="text-indigo-500 font-bold">University Online Enrollment System.</span> Any information you
                    will share within the system will only available for authorized-personnel including you. Please fill out these forms in order to
                    proceed.
                </p>
            </div>
            @if ($step == 1)
                @livewire('forms.personal-detail.fullname-form')
                <x-jet-section-border/>
            @endif
            @if ($step == 2)
                @livewire('forms.personal-detail.other-info-form')
                <x-jet-section-border/>
            @endif
            @if ($step == 3)
                @livewire('forms.contact.contact-form')
                <x-jet-section-border/>
            @endif
            @if ($step == 4)
                @livewire('forms.guardian.guardian-form', ['studentId' => $student->id])
                <x-jet-section-border/>
            @endif
            @if ($step == 5)
                @livewire('forms.education.education-form', ['studentId' => $student->id])
                <x-jet-section-border/>
            @endif
        </div>
    </div>
</div>
