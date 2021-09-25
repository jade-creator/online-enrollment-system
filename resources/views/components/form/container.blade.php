<div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
    @includeIf('partials.view-profile-button')

    <div class="flex flex-col md:flex-row">
        @includeIf('partials.account-navigation')

        <div class="w-full pl-0 md:pl-8">
            @isset ($slot)
                {{ $slot }}
            @endisset
        </div>
    </div>
</div>
