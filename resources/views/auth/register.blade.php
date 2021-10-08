<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
            <p class="mt-4 text-xl font-extrabold">{{ __('Create an account')}}</p>
            <p class="text-sm">
                <a class="font-medium text-indigo-700 hover:text-indigo-800" href="{{ route('login') }}">
                    {{ __('already registered?') }}
                </a>
            </p>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" x-data="{role_id: 0}">
            @csrf

            <div>
                <x-jet-label for="role" value="{{ __('Role') }}"/>
                <select x-model="role_id" id="role" class="block mt-1 w-full" name="role" autofocus autocomplete="role">
                    <option value="0" selected>-- select a role --</option>
                    <option value="2">Student</option>
                    <option value="5">Faculty Member</option>
                </select>
            </div>

            <div x-show="role_id == 2" class="mt-4">
                <x-jet-label for="student_id" value="{{ __('Student ID') }}" />
                <x-jet-input id="student_id" class="block mt-1 w-full" type="text" name="student_id" :value="old('student_id')" autofocus autocomplete="student_id"/>
            </div>

            <div x-show="role_id == 5" class="mt-4">
                <x-jet-label for="employee_id" value="{{ __('Employee ID') }}" />
                <x-jet-input id="employee_id" class="block mt-1 w-full" type="text" name="employee_id" :value="old('employee_id')" autofocus autocomplete="employee_id"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus autocomplete="name" placeholder="eg. John Doe"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="example@gmail.com"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms" checked="checked"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-sm text-indigo-600 hover:text-indigo-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-sm text-indigo-600 hover:text-indigo-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="block mt-4 text-center">
                <x-jet-button class="w-full mt-2 w-full bg-indigo-700 hover:bg-indigo-800" onclick="this.disabled=true;this.form.submit();">
                    {{ __('Register')}}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
