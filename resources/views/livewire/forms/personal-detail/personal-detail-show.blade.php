<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Personal Details') }}
    </h2>
</x-slot>

<div class="w-full">
    <div class="max-w-5xl mx-auto py-10 sm:px-6 lg:px-8">
        <div>
            @livewire('forms.personal-detail.fullname-form', ['person' => $person])
            <x-jet-section-border/>
        </div>
        <div class="mt-10 sm:mt-0">
            @livewire('forms.personal-detail.other-info-form', ['person' => $person])
            <x-jet-section-border/>
        </div>
        <div class="mt-10 sm:mt-0">
            @livewire('forms.personal-detail.contact-form', ['person' => $person])
            <x-jet-section-border/>
        </div>

        @if (auth()->user()->role_id == 2)
            <div class="mt-10 sm:mt-0">
                @livewire('forms.personal-detail.guardian-info-form', ['person' => $person])    
            </div>
        @endif
    </div>
</div>
