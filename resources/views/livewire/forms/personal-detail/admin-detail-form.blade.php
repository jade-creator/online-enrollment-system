<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('User Information') }}
    </h2>
</x-slot>

<div class="w-full flex flex-col md:flex-row max-w-5xl mx-auto py-5 sm:px-6 lg:px-8">
    @livewire('partials.progress-form')
    <div class="w-full py-10 sm:px-6 lg:px-8">
        @if ($step == 1)
            @livewire('forms.personal-detail.fullname-form')
            <x-jet-section-border/>
        @endif
        @if ($step == 2)
            @livewire('forms.personal-detail.other-info-form')
            <x-jet-section-border/>
        @endif
        @if ($step >= 3)
            @livewire('forms.contact.contact-form')
            <x-jet-section-border/> 
        @endif
    </div>
</div>