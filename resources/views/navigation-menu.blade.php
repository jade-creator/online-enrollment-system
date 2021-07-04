<nav x-data="{ open: false }" class="fixed w-full bg-gray-900 z-30">
    <!-- Primary Navigation Menu -->
    <div class="w-full">
        <div class="flex lg:justify-between h-14">
            <div class="flex">
                <!-- Hamburger -->
                <div class="mr-3 flex items-center" title="Toggle sidebar">
                    <button @click="open = ! open" class="h-full px-3 inline-flex items-center justify-center  text-gray-400 hover:bg-gray-700 focus:outline-none transition duration-150 ease-in-out border border-gray-900 focus:border-white">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>  
                    </button>
                </div>
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <x-jet-application-mark class="block h-9 w-auto" />
                    </a>
                    <p class="pl-2 text-white font-bold">{{ __('University') }}</p>
                </div>
            </div>

            <div class="hidden lg:flex lg:items-center lg:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="60" dropdownClasses="z-50">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-jet-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-jet-dropdown-link>
                                    @endcan

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Switch Teams') }}
                                    </div>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-jet-switchable-team :team="$team" />
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="relative" title="Manage Account">
                    <x-jet-dropdown align="right" width="48" dropdownClasses="z-50 shadow-lg">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border border-transparent focus:outline-none focus:bg-gray-700 focus:border-white transition duration-150 ease-in-out h-full px-2 py-1.5">
                                    <img class="mt-1 h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                                    <h5 class="text-white p-2 mt-1" >{{ Auth::user()->name }}<i class="fas fa-chevron-down ml-2"></i></h5>
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-4 border border-transparent text-sm leading-4 font-medium text-white hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-3 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-jet-dropdown-link href="#">
                                {{ __('Personal Profile') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Account Settings') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                         onclick="event.preventDefault();
                                                this.closest('form').submit();
                                                    " class="hover:bg-red-400 hover:text-white rounded-b-md">
                                    {{ __('Logout') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div @click="open = ! open" :class="{'w-full': open, 'lg:w-12': ! open}" class="w-12 h-full transparent fixed">
        {{-- z-40 --}}

        <div @click.stop :class="{'w-full sm:w-60 shadow-lg': open, 'w-0 lg:w-12': ! open}" class="transition-width transition-slowest ease top-0 left-0 h-full bg-white border-r border-gray-200">

            <div x-data="{ subnav: 'none' }">

                <ul class="pt-3 flex flex-col space-y-1 h-full w-full overflow-hidden scrolling-touch">
                    @if(auth()->user()->role->name === 'admin')
                        <li title="dashboard">
                            <a href="{{route('admin.dashboard')}}" class="{{ request()->is('admin/dashboard') ? 'text-indigo-500' : 'text-gray-800'}} h-11 relative flex flex-row items-center focus:outline-none hover:bg-gray-200 focus:bg-gray-200 font-bold hover:text-gray-700">
                            <span class="inline-flex justify-center items-center ml-3 pl-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" ></path>
                                </svg>
                            </span>
                            <span class="ml-4 mt-1 text-sm tracking-wide truncate">{{ __('Dashboard') }}</span>
                            </a>
                        </li>
    
                        <li title="masterlist">
                            <a href="{{route('admin.masterlist')}}" class="{{ request()->is('admin/masterlist') ? 'text-indigo-500' : 'text-gray-800'}} h-11 relative flex flex-row items-center focus:outline-none hover:bg-gray-200 focus:bg-gray-200 font-bold hover:text-gray-700">
                                <span class="inline-flex justify-center items-center ml-3 pl-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </span>
                                <span class="ml-4 mt-1 text-sm tracking-wide truncate">{{ __('Masterlist') }}</span>
                            </a>
                        </li>

                        <li title="Subjects">
                            <a href="{{route('admin.subjects.view')}}" class="{{ request()->is('admin/subjects/*') || request()->is('admin/subjects') ? 'text-indigo-500' : 'text-gray-800'}} h-11 relative flex flex-row items-center focus:outline-none hover:bg-gray-200 focus:bg-gray-200 font-bold hover:text-gray-700">
                                <span class="inline-flex justify-center items-center ml-3 pl-0.5">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" width="22" height="24" stroke="currentColor" id="library"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                                </span>
                                <span class="ml-4 mt-1 text-sm tracking-wide truncate">{{ __('Subjects') }}</span>
                            </a>
                        </li>

                        <li title="Specializations">
                            <a href="{{route('admin.specializations.view')}}" class="{{ request()->is('admin/specializations/*') || request()->is('admin/specializations') ? 'text-indigo-500' : 'text-gray-800'}} h-11 relative flex flex-row items-center focus:outline-none hover:bg-gray-200 focus:bg-gray-200 font-bold hover:text-gray-700">
                                <span class="inline-flex justify-center items-center ml-3 pl-0.5">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" width="22" height="24" stroke="currentColor" id="library"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                                </span>
                                <span class="ml-4 mt-1 text-sm tracking-wide truncate">{{ __('Specializations') }}</span>
                            </a>
                        </li>

                        <li title="Programs">
                            <a href="{{route('admin.programs.view')}}" class="{{ request()->is('admin/programs/*') || request()->is('admin/programs') ? 'text-indigo-500' : 'text-gray-800'}} h-11 relative flex flex-row items-center focus:outline-none hover:bg-gray-200 focus:bg-gray-200 font-bold hover:text-gray-700">
                                <span class="inline-flex justify-center items-center ml-3 pl-0.5">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" width="22" height="24" stroke="currentColor" id="library"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                                </span>
                                <span class="ml-4 mt-1 text-sm tracking-wide truncate">{{ __('Programs') }}</span>
                            </a>
                        </li>

                        <li title="School Year">
                            <a href="{{route('admin.school.year.view')}}" class="{{ request()->is('admin/school-management/years*') || request()->is('admin/school-management/years') ? 'text-indigo-500' : 'text-gray-800'}} h-11 relative flex flex-row items-center focus:outline-none hover:bg-gray-200 focus:bg-gray-200 font-bold hover:text-gray-700">
                                <span class="inline-flex justify-center items-center ml-3 pl-0.5">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" width="22" height="24" stroke="currentColor" id="library"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                                </span>
                                <span class="ml-4 mt-1 text-sm tracking-wide truncate">{{ __('School Year') }}</span>
                            </a>
                        </li>
                        
                        <li title="users">
                            <a href="{{route('admin.users.view')}}" class="{{ request()->is('admin/users/*') || request()->is('admin/users') ? 'text-indigo-500' : 'text-gray-800'}} h-11 relative flex flex-row items-center focus:outline-none hover:bg-gray-200 focus:bg-gray-200 font-bold hover:text-gray-700">
                                <span class="inline-flex justify-center items-center ml-3 pl-0.5">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                </span>
                                <div class="flex flex-row items-center justify-between w-full ml-4 pr-4" @mouseover="subnav = 'users'" @click.away="subnav = 'none'">
                                    <span class="mt-1 text-sm tracking-wide truncate">{{ __('Users') }}</span>
                                    <svg class="h-3 text-gray-400" fill="none" stroke="currentColor" fill-rule="evenodd" viewBox="0 0 7 12"><path fill-rule="nonzero" d="M5.569 5.994L0 .726.687 0l6.336 5.994-6.335 6.002L0 11.27z"></path></svg>    
                                </div>
                            </a>
                        </li>

                        <li x-show="subnav == 'users'">
                            <a href="{{route('admin.users.view')}}" class="pl-9 relative flex flex-row items-center h-11 hover:bg-gray-100 text-gray-500 hover:text-gray-700">
                                <span class="ml-4 mt-1 text-xs tracking-wide truncate">{{ __('View Users')}}</span>
                            </a>
                            <a href="{{route('admin.users.create')}}" class="pl-9 relative flex flex-row items-center h-11 hover:bg-gray-100 text-gray-500 hover:text-gray-700">
                                <span class="ml-4 mt-1 text-xs tracking-wide truncate">{{ __('Add User')}}</span>
                            </a>
                        </li>
                    @endif
    
                    @if(auth()->user()->role->name === 'student')
                        <li title="registration">
                            <a href="{{route('student.registration')}}" class="{{ request()->is('student/registration') ? 'font-bold text-indigo-500' : 'text-gray-800'}} relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-200 text-gray-500 hover:text-gray-700">
                            <span class="inline-flex justify-center items-center ml-3 pl-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" ></path>
                                </svg>
                            </span>
                            <span class="ml-4 mt-1 text-sm tracking-wide truncate">{{ __('Registration') }}</span>
                            </a>
                        </li>
                
                    @endif
                    <!-- Responsive Settings Options -->
                    <div class="block lg:hidden pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            @if ( Laravel\Jetstream\Jetstream::managesProfilePhotos() )
                                <div class="flex-shrink-0 mr-3">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </div>
                            @endif
    
                            <div>
                                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
    
                        <div class="mt-3 space-y-1">
                            <!-- Account Management -->
                            <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" >
                                {{ __('Profile') }}
                            </x-jet-responsive-nav-link>
    
                            <x-jet-responsive-nav-link href="{{ route('user.personal-details') }}" :active="request()->routeIs('user.personal-details')" >
                                {{ __('Personal Details') }}
                            </x-jet-responsive-nav-link>
    
                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                                    {{ __('API Tokens') }}
                                </x-jet-responsive-nav-link>
                            @endif
    
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
    
                                <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                                    class="hover:bg-red-400 hover:text-white">
                                    {{ __('Logout') }}
                                </x-jet-responsive-nav-link>
                            </form>
    
                            <!-- Team Management -->
                            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                <div class="border-t border-gray-200"></div>
    
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Team') }}
                                </div>
    
                                <!-- Team Settings -->
                                <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                                    {{ __('Team Settings') }}
                                </x-jet-responsive-nav-link>
    
                                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                    <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                        {{ __('Create New Team') }}
                                    </x-jet-responsive-nav-link>
                                @endcan
    
                                <div class="border-t border-gray-200"></div>
    
                                <!-- Team Switcher -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Switch Teams') }}
                                </div>
    
                                @foreach (Auth::user()->allTeams() as $team)
                                    <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                                @endforeach
                            @endif
                        </div>
                    </div>
                </ul>  
            </div>

        </div>
    </div>
</nav>
