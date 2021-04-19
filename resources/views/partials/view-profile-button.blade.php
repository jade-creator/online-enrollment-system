<div class="py-10 flex items-center justify-between">
    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
        <div class="flex items-start">
            <img class="border border-gray-200 mt-1 h-16 w-16 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="photo"/>
            <div class="px-6 py-2 flex flex-col text-2xl">
                <h2>{{ auth()->user()->name }}</h2>
                <p class="text-sm text-gray-600 mt-1 tracking-widest">{{ __('Personal Account')}}</p>
            </div>
        </div>
    @endif

    @auth
        <x-jet-secondary-button class="">
            {{ __('Go to personal profile')}}
        </x-jet-secondary-button>
    @endauth
</div>