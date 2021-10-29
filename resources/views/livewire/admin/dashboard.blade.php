<div class="pt-5 px-5  lg:pl-6 w-full h-full overflow-y-auto scrolling-touch flex-1">
    <div class="w-full mb-6 pt-3">
        <div>
            <x-dashboard.container>
                <div class="flex flex-col">
                    <div class="transition text-xs uppercase font-light text-gramy-500">{{ __('OVERVIEW') }}</div>
                    <div class="text-xl font-bold">{{ __('Dashboard') }}</div>
                </div>
            </x-dashboard.container>

            <x-dashboard.container>
                {{--USERS WIDGET--}}
                <x-dashboard.slot>
                    <x-dashboard.widget title="Users" :value="$users">
                        <x-icons.users-icon/>
                    </x-dashboard.widget>
                </x-dashboard.slot>

                {{--PRE REGS WIDGET--}}
                <x-dashboard.slot>
                    <x-dashboard.widget title="Pre Registrations" :value="$registrations">
                        <x-icons.pre-enrollment-icon/>
                    </x-dashboard.widget>
                </x-dashboard.slot>

                {{--SECTIONS WIDGET--}}
                <x-dashboard.slot>
                    <x-dashboard.widget title="Sections" :value="$sections">
                        <x-icons.section-icon/>
                    </x-dashboard.widget>
                </x-dashboard.slot>

                {{--SUBS WIDGET--}}
                <x-dashboard.slot>
                    <x-dashboard.widget title="Subjects" :value="$subjects">
                        <x-icons.subject-icon/>
                    </x-dashboard.widget>
                </x-dashboard.slot>
            </x-dashboard.container>

            <x-dashboard.container>
                {{--DOUGHNUT CHART--}}
                <x-dashboard.slot minWidth="3">
                    <x-dashboard.chart>
                        <div class="w-60 h-60">
                            <canvas id="genderChart"></canvas>
                        </div>
                        <div class="w-60 h-60">
                            <canvas id="userRoleChart"></canvas>
                        </div>
                        <div class="w-60 h-60">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </x-dashboard.chart>
                </x-dashboard.slot>

                {{-- RECENTLY ENROLLED WIDGET--}}
                <x-dashboard.slot>
                    <x-dashboard.widget :default="false">
                        <div class="flex flex-row justify-between mb-6">
                            <div class="flex flex-col">
                                <div class="text-sm font-light text-gray-500">Recently Enrolled</div>
                                <div class="text-sm font-bold"><span>All Levels</span></div>
                            </div>
                            <div class="mt-2 text-gray-400 hover:text-green-500 cursor-pointer">
                                <i class="fas fa-redo-alt"></i>
                            </div>
                        </div>
                        @foreach ($this->recentlyEnrollees as $enrollee)
                            <div class="flex items-center justify-start p-2 space-x-4 mb-5">
                                <div class="flex-shrink-0 w-10">
                                    <img class="h-10 w-10 rounded-full" src="{{ $enrollee->student->user->profile_photo_url }}" alt="{{ $enrollee->student->user->person->firstname }}">
                                </div>
                                <div class="flex flex-col w-full">
                                    <div class="flex flex-row justify-between text-sm font-bold">
                                        <div class="w-52"><p class="truncate">{{ $enrollee->student->user->person->full_name }}</p></div>
                                    </div>
                                    <div class="text-sm">{{ $enrollee->section->name ?? 'N/A' }}
                                    <span class="mx-1">{{ Carbon\Carbon::parse($enrollee->created_at)->format('F j') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </x-dashboard.widget>
                </x-dashboard.slot>
            </x-dashboard.container>

            <x-dashboard.container>
                {{--PROGRAMS CHART--}}
                <x-dashboard.chart>
                    <canvas id="programChart" height="150"></canvas>
                </x-dashboard.chart>
            </x-dashboard.container>
        </div>

        <div wire:loading>
            @include('partials.loading')
        </div>
    </div>

    @push('scripts')
        <!-- Chart.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script defer>
            var gender = document.getElementById("genderChart").getContext("2d");
            var userRole = document.getElementById("userRoleChart").getContext("2d");
            var studentStatus = document.getElementById("statusChart").getContext("2d");
            var program = document.getElementById("programChart").getContext("2d");

            var genderChart = new Chart(gender, {
                type: "doughnut",
                data: {
                    labels: ["Female", "Male", "Other", "Prefer not to say"],
                    datasets: [
                        {
                            label: "Gender",
                            data: [{{ $female }}, {{ $male }}, {{ $other }}, {{ $prefer }}],
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.5)",
                                "rgba(54, 162, 235, 0.5)",
                                "rgba(155, 89, 182, 0.5)",
                                "rgba(39, 174, 96, 0.5)",
                            ],
                            borderColor: ["rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)", "rgba(155, 89, 182, 1)", "rgba(39, 174, 96, 1)"],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    plugins: {
                        legend: {
                            position: "right",
                            labels: {
                                boxWidth: 10,
                            },
                        },
                        title: {
                            display: true,
                            text: "Gender",
                            position: "top",
                        },
                    },
                },
            });

            var userRoleChart = new Chart(userRole, {
                type: "doughnut",
                data: {
                    labels: ["Admin", "Student", "Registrar", "Dean", "Faculty Members"],
                    datasets: [
                        {
                            label: "Users",
                            data: [{{ $admin }}, {{ $student }}, {{ $registrar }}, {{ $dean }}, {{ $faculty }}],
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.5)",
                                "rgba(54, 162, 235, 0.5)",
                                "rgba(39, 174, 96, 0.5)",
                                "rgba(52, 73, 94, 0.5)",
                                "rgba(155, 89, 182, 0.5)",
                            ],
                            borderColor: [
                                "rgba(255, 99, 132, 1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(39, 174, 96, 1)",
                                "rgba(52, 73, 94, 1)",
                                "rgba(155, 89, 182, 1)",
                            ],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    plugins: {
                        legend: {
                            position: "right",
                            labels: {
                                boxWidth: 10,
                            },
                        },
                        title: {
                            display: true,
                            text: "Users",
                            position: "top",
                        },
                    },
                },
            });

            var statusChart = new Chart(studentStatus, {
                type: "doughnut",
                data: {
                    labels: ["Enrolled", "Finalized", "Confirming", "Pending"],
                    datasets: [
                        {
                            label: "Status",
                            data: [{{ $enrolled }}, {{ $finalized }}, {{ $confirming }}, {{ $pending }}],
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.5)",
                                "rgba(54, 162, 235, 0.5)",
                                "rgba(155, 89, 182, 0.5)",
                                "rgba(39, 174, 96, 0.5)",
                            ],
                            borderColor: [
                                "rgba(255, 99, 132, 1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(155, 89, 182, 1)",
                                "rgba(39, 174, 96, 1)",
                            ],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    plugins: {
                        legend: {
                            position: "right",
                            labels: {
                                boxWidth: 10,
                            },
                        },
                        title: {
                            display: true,
                            text: "Registration Status",
                            position: "top",
                        },
                    },
                },
            });

            var programChart = new Chart(program, {
                type: "bar",
                data: {
                    labels: @json($programsCode),
                    datasets: [
                        {
                            label: "Programs",
                            data: @json($programsData),
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.5)",
                                "rgba(54, 162, 235, 0.5)",
                                "rgba(39, 174, 96, 0.5)",
                                "rgba(52, 73, 94, 0.5)",
                                "rgba(155, 89, 182, 0.5)",
                            ],
                            borderColor: [
                                "rgba(255, 99, 132, 1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(39, 174, 96, 1)",
                                "rgba(52, 73, 94,1.0)",
                                "rgba(155, 89, 182,1.0)",
                            ],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    scale: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                    plugins: {
                        subtitle: {
                            display: true,
                            text: '{{ $programsTableTitle }}',
                        },
                    },
                },
            });
        </script>
    @endpush
 </div>
