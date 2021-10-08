<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
            <p class="mt-4 text-xl font-extrabold">{{ __('Log in to your account')}}</p>
            <p class="text-sm">{{__('Or')}} 
                <a class="font-medium text-indigo-700 hover:text-indigo-800" href="{{ route('register') }}">
                    {{ __('create new account') }}
                </a>
            </p>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="example@gmail.com"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-between my-5">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 font-medium text-sm text-gray-700">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                <a class="font-medium text-sm text-indigo-700 hover:text-indigo-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif
            </div>

            <div class="block mt-4 text-center">
                <x-jet-button class="w-full bg-indigo-700 hover:bg-indigo-800" onclick="this.disabled=true;this.form.submit();" >
                    {{ __('Log in') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
