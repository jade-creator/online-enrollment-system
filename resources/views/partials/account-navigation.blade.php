<div class="flex flex-col h-auto mb-3 md:h-0">
    <div class="bg-gray-100 border border-gray-300 rounded-md w-full lg:w-64 md:w-60">
        <div class="border-b border-gray-200">
            <p class="py-3 px-5 font-bold text-sm">Account settings</p>
        </div>

        <div class="border-b border-gray-200">
            <a href="{{ route('profile.show') }}">
                <p class="py-3 text-sm {{ request()->is('user/profile') ? 'border-l-4 border-indigo-500 px-4' : 'px-5 hover:bg-gray-200'}}">Profile</p>
            </a>
        </div>

        <div class="border-b border-gray-200">
            <a href="{{ route('user.personal-details') }}">
                <p class="py-3 text-sm {{ request()->is('user/personal-details') ? 'border-l-4 border-indigo-500 px-4' : 'px-5 hover:bg-gray-200'}}">Personal details</p>
            </a>
        </div>

        <div class="border-b border-gray-200">
            <a href="{{ route('user.contacts') }}">
                <p class="py-3 text-sm {{ request()->is('user/contacts') ? 'border-l-4 border-indigo-500 px-4' : 'px-5 hover:bg-gray-200'}}">Contacts</p>
            </a>
        </div>

        @if (auth()->user()->role->name === 'student')
            <div class="border-b border-gray-200">
                <a href="{{ route('user.guardian-details') }}">
                    <p class="py-3 text-sm {{ request()->is('user/guardian-details') ? 'border-l-4 border-indigo-500 px-4' : 'px-5 hover:bg-gray-200'}}">Guardian Details</p>
                </a>
            </div>

            <div class="border-b border-gray-200">
                <a href="{{ route('user.education') }}">
                    <p class="py-3 text-sm {{ request()->is('user/education') ? 'border-l-4 border-indigo-500 px-4' : 'px-5 hover:bg-gray-200'}}">Education</p>
                </a>
            </div>
        @endif

        <div class="border-b border-gray-200">
            <a href="{{ route('user.security-settings') }}">
                <p class="py-3 text-sm {{ request()->is('user/security-settings') ? 'border-l-4 border-indigo-500 px-4' : 'px-5 hover:bg-gray-200'}}">Security settings</p>
            </a>
        </div>
    </div>
</div>
