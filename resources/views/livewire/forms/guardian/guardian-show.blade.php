<div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
    @include('partials.view-profile-button')

    <div class="flex flex-col md:flex-row">
        @include('partials.account-navigation')

        <div class="w-full pl-0 md:pl-8">
            <div class="mt-10 sm:mt-0">
                @livewire('forms.guardian.guardian-form')
                <x-jet-section-border/>
            </div>
        </div>
    </div>
</div>
