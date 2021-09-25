<x-form.container>
    <div class="w-full pl-0 md:pl-8">
        <div>
            @livewire('forms.personal-detail.fullname-form')
            <x-jet-section-border/>
        </div>

        <div class="mt-10 sm:mt-0">
            @livewire('forms.personal-detail.other-info-form')
            <x-jet-section-border/>
        </div>
    </div>
</x-form.container>
