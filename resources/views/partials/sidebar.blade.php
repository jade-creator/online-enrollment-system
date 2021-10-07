<!-- Responsive Navigation Menu -->
<div @click="open = ! open" :class="{'w-full': open, 'lg:w-12': ! open}" class="pb-14 w-0 h-full bg-gray-500 bg-opacity-50 fixed">

    <div @click.stop :class="{'w-full sm:w-1/2 lg:w-64 shadow-lg': open, 'w-0 lg:w-12': ! open}" class="overflow-y-auto overflow-x-hidden transition-width transition-slowest ease h-full bg-white border-r border-gray-200">
        <ul class="flex flex-col h-content w-full">
            @if(auth()->user()->role->name === 'admin')

                <x-sidebar.item title="Dashboard">
                    <x-sidebar.link routeName="admin.dashboard" route="admin/dashboard" name="Dashboard">
                        <x-icons.dashboard-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Pre Enrollment">
                    <x-sidebar.link routeName="admin.pre.enrollments.view" route="admin/pre-enrollments" name="Pre Enrollment">
                        <x-icons.pre-enrollment-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Sections">
                    <x-sidebar.link routeName="sections.view" route="sections" name="Sections">
                        <x-icons.section-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Faculties">
                    <x-sidebar.link routeName="admin.faculties.view" route="admin/faculties" name="Faculties">
                        <x-icons.faculty-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Grades">
                    <x-sidebar.link routeName="admin.grades.view" route="admin/grades" name="Grades">
                        <x-icons.grade-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Prospectus">
                    <x-sidebar.link routeName="admin.prospectuses.view" route="admin/prospectuses" parameter="prospectusId" value="1" name="Prospectus">
                        <x-icons.prospectus-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Subjects">
                    <x-sidebar.link routeName="admin.subjects.view" route="admin/subjects" name="Subjects">
                        <x-icons.subject-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Programs">
                    <x-sidebar.link routeName="admin.programs.view" route="admin/programs" name="Programs">
                        <x-icons.program-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Fees">
                    <x-sidebar.link routeName="admin.fees.view" route="admin/fees" name="Fees">
                        <x-icons.fee-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Advising">
                    <x-sidebar.link routeName="admin.advising.view" route="admin/advising" name="Advising">
                        <x-icons.advising-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Users">
                    <x-sidebar.link routeName="admin.users.view" route="admin/users" name="Users">
                        <x-icons.users-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>
            @endif

            @if(auth()->user()->role->name === 'student')

                <x-sidebar.item title="Registrations">
                    <x-sidebar.link routeName="student.registrations.index" route="student/pre-registrations" name="Registrations">
                        <x-icons.pre-enrollment-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Schedules">
                    <x-sidebar.link routeName="sections.view" route="sections" name="Schedules">
                        <x-icons.section-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Grades">
                    <x-sidebar.link routeName="student.grades.view" route="student/grades" name="Grades">
                        <x-icons.grade-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Payments">
                    <x-sidebar.link routeName="student.payments.view" route="student/payments" name="Payments">
                        <x-icons.credit-card-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

{{--                <x-sidebar.item title="Prospectus">--}}
{{--                    <x-sidebar.link routeName="prospectuses.view" route="prospectuses" name="Prospectus">--}}
{{--                        <x-icons.prospectus-icon/>--}}
{{--                    </x-sidebar.link>--}}
{{--                </x-sidebar.item>--}}
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
