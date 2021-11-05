<div @click="open = ! open"
     :class="{'w-full': open, 'lg:w-12': ! open}"
     class="pb-14 w-0 h-full bg-gray-500 bg-opacity-50 fixed">

    <div @click.stop
         :class="{'w-full sm:w-1/2 lg:w-64 shadow-lg': open, 'w-0 lg:w-12': ! open}"
         class="sidebar overflow-y-auto overflow-x-hidden transition-width transition-slowest ease h-full bg-white border-r border-gray-200">

        <ul class="flex flex-col h-content w-full">
            @if (auth()->user()->role->name === 'admin')
                <x-sidebar.item title="Dashboard">
                    <x-sidebar.link routeName="admin.dashboard" :routes="['admin.dashboard']" name="Dashboard">
                        <x-icons.dashboard-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <div x-data="{ dropdown: false }">
                    <x-sidebar.dropdown :routes="['admin.pre.enrollments.view', 'admin.advising.view', 'admin.students.registration.create',
                        'admin.students.regular.create', 'admin.students.irregular.create', 'sections.view', 'admin.advising.create',
                        'admin.advising.update', 'admin.sections.create', 'admin.sections.update']" title="Pre Enrollment">

                        <x-icons.pre-enrollment-icon/>
                    </x-sidebar.dropdown>

                    <x-sidebar.item
                        x-show="dropdown"
                        class="bg-gray-200"
                        title="View List - Pre Enrollments">

                        <x-sidebar.link
                            routeName="admin.pre.enrollments.view"
                            :routes="['admin.pre.enrollments.view']"
                            name="View List"
                            activeColor="bg-indigo-100 hover:bg-indigo-50"
                            defaultColor="bg-gray-100 hover:bg-gray-200">
                            <span class="text-black"><x-icons.list-icon stroke-width="2.5"/></span>
                        </x-sidebar.link>
                    </x-sidebar.item>

                    <x-sidebar.item
                        x-show="dropdown"
                        class="bg-gray-200"
                        title="Advising Schedules">

                        <x-sidebar.link
                            routeName="admin.advising.view"
                            :routes="['admin.advising.view', 'admin.advising.create', 'admin.advising.update']"
                            name="Advising Schedules"
                            activeColor="bg-indigo-100 hover:bg-indigo-50"
                            defaultColor="bg-gray-100 hover:bg-gray-200">
                            <x-icons.advising-icon/>
                        </x-sidebar.link>
                    </x-sidebar.item>

                    <x-sidebar.item
                        x-show="dropdown"
                        class="bg-gray-200"
                        title="Sections">

                        <x-sidebar.link
                            routeName="sections.view"
                            :routes="['sections.view', 'admin.sections.create', 'admin.sections.update']"
                            name="Sections"
                            activeColor="bg-indigo-100 hover:bg-indigo-50"
                            defaultColor="bg-gray-100 hover:bg-gray-200">
                            <x-icons.section-icon/>
                        </x-sidebar.link>
                    </x-sidebar.item>
                </div>

                <div x-data="{ dropdown: false }">
                    <x-sidebar.dropdown :routes="['admin.curricula.view', 'admin.prospectuses.view', 'admin.programs.view',
                        'admin.subjects.view', 'admin.curricula.create', 'admin.curricula.update', 'admin.programs.create',
                        'admin.programs.update', 'admin.subjects.create', 'admin.subjects.update']" title="Curricula">

                        <x-icons.curriculum-icon/>
                    </x-sidebar.dropdown>

                    <x-sidebar.item
                        x-show="dropdown"
                        class="bg-gray-200"
                        title="View List - Curricula">

                        <x-sidebar.link
                            routeName="admin.curricula.view"
                            :routes="['admin.curricula.view', 'admin.curricula.create', 'admin.curricula.update']"
                            name="View List"
                            activeColor="bg-indigo-100 hover:bg-indigo-50"
                            defaultColor="bg-gray-100 hover:bg-gray-200">
                            <span class="text-black"><x-icons.list-icon stroke-width="2.5"/></span>
                        </x-sidebar.link>
                    </x-sidebar.item>

                    <x-sidebar.item
                        x-show="dropdown"
                        class="bg-gray-200"
                        title="Prospectus">

                        <x-sidebar.link
                            routeName="admin.prospectuses.view"
                            :routes="['admin.prospectuses.view']"
                            name="Prospectus"
                            activeColor="bg-indigo-100 hover:bg-indigo-50"
                            defaultColor="bg-gray-100 hover:bg-gray-200">
                            <x-icons.prospectus-icon/>
                        </x-sidebar.link>
                    </x-sidebar.item>

                    <x-sidebar.item
                        x-show="dropdown"
                        class="bg-gray-200"
                        title="Programs">

                        <x-sidebar.link
                            routeName="admin.programs.view"
                            :routes="['admin.programs.view', 'admin.programs.create', 'admin.programs.update']"
                            name="Programs"
                            activeColor="bg-indigo-100 hover:bg-indigo-50"
                            defaultColor="bg-gray-100 hover:bg-gray-200">
                            <x-icons.program-icon/>
                        </x-sidebar.link>
                    </x-sidebar.item>

                    <x-sidebar.item
                        x-show="dropdown"
                        class="bg-gray-200"
                        title="Subjects">

                        <x-sidebar.link
                            routeName="admin.subjects.view"
                            :routes="['admin.subjects.view', 'admin.subjects.create', 'admin.subjects.update']"
                            name="Subjects"
                            activeColor="bg-indigo-100 hover:bg-indigo-50"
                            defaultColor="bg-gray-100 hover:bg-gray-200">
                            <x-icons.subject-icon/>
                        </x-sidebar.link>
                    </x-sidebar.item>
                </div>

                <x-sidebar.item title="Grading">
                    <x-sidebar.link routeName="admin.grades.view" :routes="['admin.grades.view', 'admin.grade.report']" name="Grading">

                        <x-icons.grade-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Faculties">
                    <x-sidebar.link routeName="admin.faculties.view" :routes="['admin.faculties.view', 'admin.faculties.create', 'admin.faculties.update']" name="Faculties">
                        <x-icons.faculty-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Fees">
                    <x-sidebar.link routeName="admin.fees.view" :routes="['admin.fees.view', 'admin.fees.create', 'admin.fees.update']" name="Fees">
                        <x-icons.fee-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Payments">
                    <x-sidebar.link routeName="admin.payments.view" :routes="['admin.payments.view']" name="Payments">
                        <x-icons.credit-card-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <div x-data="{ dropdown: false }">
                    <x-sidebar.dropdown :routes="['admin.users.view', 'users.students.index', 'admin.users.create', 'user.personal.profile.view',
                    'admin.student.update']" title="Users">
                        <x-icons.users-icon/>
                    </x-sidebar.dropdown>

                    <x-sidebar.item
                        x-show="dropdown"
                        class="bg-gray-200"
                        title="View List - All Users">

                        <x-sidebar.link
                            routeName="admin.users.view"
                            :routes="['admin.users.view', 'admin.users.create', 'user.personal.profile.view']"
                            name="View List"
                            activeColor="bg-indigo-100 hover:bg-indigo-50"
                            defaultColor="bg-gray-100 hover:bg-gray-200">
                            <span class="text-black"><x-icons.list-icon stroke-width="2.5"/></span>
                        </x-sidebar.link>
                    </x-sidebar.item>

                    <x-sidebar.item
                        x-show="dropdown"
                        class="bg-gray-200"
                        title="Students">

                        <x-sidebar.link
                            routeName="users.students.index"
                            :routes="['users.students.index', 'admin.student.update']"
                            name="Students"
                            activeColor="bg-indigo-100 hover:bg-indigo-50"
                            defaultColor="bg-gray-100 hover:bg-gray-200">
                            <span class="text-black"><x-icons.student-icon stroke-width="2.5"/></span>
                        </x-sidebar.link>
                    </x-sidebar.item>
                </div>

                <x-sidebar.item title="Settings">
                    <x-sidebar.link routeName="admin.settings" :routes="['admin.settings']" name="Settings">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </x-sidebar.link>
                </x-sidebar.item>
            @elseif (auth()->user()->role->name === 'registrar')
                <x-sidebar.item title="Pre Enrollment">
                    <x-sidebar.link routeName="admin.pre.enrollments.view" :routes="['admin.pre.enrollments.view', 'admin.students.registration.create', 'admin.students.regular.create', 'admin.students.irregular.create', 'pre.registration.view']"  name="Pre Enrollment">
                        <x-icons.pre-enrollment-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Sections">
                    <x-sidebar.link routeName="sections.view" :routes="['sections.view']" name="Sections">
                        <x-icons.section-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Grades">
                    <x-sidebar.link routeName="admin.grades.view" :routes="['admin.grades.view', 'admin.grade.report']" name="Grades">
                        <x-icons.grade-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Payments">
                    <x-sidebar.link routeName="admin.payments.view" :routes="['admin.payments.view']" name="Payments">
                        <x-icons.credit-card-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Students">
                    <x-sidebar.link routeName="users.students.index" :routes="['users.students.index', 'user.personal.profile.view', 'admin.student.update']" name="Students">
                        <x-icons.users-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>
            @elseif (auth()->user()->role->name === 'dean')
                <x-sidebar.item title="Pre Enrollment">
                    <x-sidebar.link routeName="admin.pre.enrollments.view" :routes="['admin.pre.enrollments.view', 'pre.registration.view']"  name="Pre Enrollment">
                        <x-icons.pre-enrollment-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Grades">
                    <x-sidebar.link routeName="admin.grades.view" :routes="['admin.grades.view']" name="Grades">
                        <x-icons.grade-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Sections">
                    <x-sidebar.link routeName="sections.view" :routes="['sections.view', 'admin.sections.create', 'admin.sections.update']" name="Sections">
                        <x-icons.section-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Prospectus">
                    <x-sidebar.link routeName="admin.prospectuses.view" :routes="['admin.prospectuses.view']" name="Prospectus">
                        <x-icons.prospectus-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Faculties">
                    <x-sidebar.link routeName="admin.faculties.view" :routes="['admin.faculties.view', 'admin.faculties.update']" name="Faculties">
                        <x-icons.faculty-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Payments">
                    <x-sidebar.link routeName="admin.payments.view" :routes="['admin.payments.view']" name="Payments">
                        <x-icons.credit-card-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>
            @elseif (auth()->user()->role->name === 'faculty member')
                <x-sidebar.item title="Pre Enrollment">
                    <x-sidebar.link routeName="admin.pre.enrollments.view" :routes="['admin.pre.enrollments.view', 'pre.registration.view']"  name="Pre Enrollment">
                        <x-icons.pre-enrollment-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Grades">
                    <x-sidebar.link routeName="admin.grades.view" :routes="['admin.grades.view']" name="Grades">
                        <x-icons.grade-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Sections">
                    <x-sidebar.link routeName="sections.view" :routes="['sections.view', 'admin.sections.create', 'admin.sections.update']" name="Sections">
                        <x-icons.section-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>
            @elseif (auth()->user()->role->name === 'student')
                <x-sidebar.item title="Registrations">
                    <x-sidebar.link routeName="student.registrations.index" :routes="['student.registrations.index', 'student.registrations.create', 'pre.registration.view', 'student.registrations.regular.create', 'student.registrations.irregular.create']" name="Registrations">
                        <x-icons.pre-enrollment-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Prospectus">
                    <x-sidebar.link routeName="student.grades.view" :routes="['student.grades.view']" name="Prospectus">
                        <x-icons.prospectus-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>

                <x-sidebar.item title="Payments">
                    <x-sidebar.link routeName="student.payments.view" :routes="['student.payments.view', 'student.paywithpaypal']" name="Payments">
                        <x-icons.credit-card-icon/>
                    </x-sidebar.link>
                </x-sidebar.item>
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
