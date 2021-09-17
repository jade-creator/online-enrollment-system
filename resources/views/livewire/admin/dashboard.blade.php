<div class="pt-5 px-5  lg:pl-6 w-full h-full overflow-y-auto scrolling-touch flex-1">
    <div class="w-full mb-6 pt-3">
        <div>
            <div class="flex flex-row items-top justify-between mb-4">
                <div class="flex flex-col">
                    <div class="transition text-xs uppercase font-light text-gramy-500">{{ __('OVERVIEW') }}</div>
                    <div class="text-xl font-bold">{{ __('Dashboard') }}</div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row w-full lg:space-x-4 space-y-2 lg:space-y-0 mb-2 lg:mb-4">
                <div class="w-full lg:w-1/4">
                    <div class="widget w-full p-4 rounded-lg bg-white border border-gray-100 shadow dark:bg-gray-900 dark:border-gray-800">
                        <div class="flex flex-row items-center justify-between">
                            <div class="flex flex-col">
                                <div class="text-xs uppercase font-light text-gray-500">Users</div>
                                <div class="text-xl font-bold">{{ $this->users->count() }}</div>
                            </div>
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="stroke-current text-gray-500" height="24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-1/4">
                    <div class="widget w-full p-4 rounded-lg bg-white border border-gray-100 shadow dark:bg-gray-900 dark:border-gray-800">
                        <div class="flex flex-row items-center justify-between">
                            <div class="flex flex-col">
                                <div class="text-xs uppercase font-light text-gray-500">Pre Enrollments</div>
                                <div class="text-xl font-bold">{{ $this->registrations->count() }}</div>
                            </div>
                            <svg class="stroke-current text-gray-500" fill="none" stroke="currentColor" stroke-width="2" height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-1/4">
                    <div class="widget w-full p-4 rounded-lg bg-white border border-gray-100 shadow dark:bg-gray-900 dark:border-gray-800">
                        <div class="flex flex-row items-center justify-between">
                            <div class="flex flex-col">
                                <div class="text-xs uppercase font-light text-gray-500">Sections</div>
                                <div class="text-xl font-bold">{{ $this->sections->count() }}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current text-gray-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="9" y1="12" x2="15" y2="12"></line>
                                <line x1="12" y1="9" x2="12" y2="15"></line>
                                <path d="M4 6v-1a1 1 0 0 1 1 -1h1m5 0h2m5 0h1a1 1 0 0 1 1 1v1m0 5v2m0 5v1a1 1 0 0 1 -1 1h-1m-5 0h-2m-5 0h-1a1 1 0 0 1 -1 -1v-1m0 -5v-2m0 -5"></path>
                             </svg>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-1/4">
                    <div class="widget w-full p-4 rounded-lg bg-white border border-gray-100 shadow dark:bg-gray-900 dark:border-gray-800">
                        <div class="flex flex-row items-center justify-between">
                            <div class="flex flex-col">
                                <div class="text-xs uppercase font-light text-gray-500">Subjects</div>
                                <div class="text-xl font-bold">{{ $this->subjects->count() }}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current text-gray-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="6" y1="9" x2="12" y2="9"></line>
                                <line x1="4" y1="5" x2="8" y2="5"></line>
                                <path d="M6 5v11a1 1 0 0 0 1 1h5"></path>
                                <rect x="12" y="7" width="8" height="4" rx="1"></rect>
                                <rect x="12" y="15" width="8" height="4" rx="1"></rect>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row w-full lg:space-x-4 space-y-2 lg:space-y-0 mb-2 lg:mb-4">
                
                <div class="w-full lg:w-3/4">
                    <!-- <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto">
                            <div class="py-2 align-middle inline-block min-w-full ">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg h-screen bg-gray-50">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Section
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Level
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse ($this->allRegistrations as $registration)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="{{ $registration->student->user->profile_photo_url }}" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $registration->student->user->person->full_name }}
                                                    </div>
                                                    <div class="text-sm text-indigo-500">
                                                        {{ $registration->student->user->student->custom_id ?? 'N/A' }}
                                                    </div>
                                                    </div>
                                                </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $registration->status->name ?? 'N/A' }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold text-green-800">
                                                    {{ $registration->section->name ?? 'N/A'}}
                                                </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $registration->prospectus->level->level ?? 'N/A'}}
                                                </td>
                                                <td class="whitespace-nowrap text-center text-sm font-medium">
                                                    <a href="{{ route('pre.registration.view', ['regId' => $registration->id]) }}">
                                                        <button class="text-blue-500 hover:text-white hover:bg-blue-500  hover:text-xs text-sm px-1.5 py-1 rounded-full hover:shadow-md outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" title="edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center">No registration found.🤔</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="flex flex-wrap justify-around bg-white rounded-lg p-4 border border-gray-100 shadow overflow-hidden dark:bg-gray-900 dark:border-gray-800">
                        <div class="w-60 h-60">
                            <canvas id="genderChart"></canvas>
                        </div>
                        <div class="w-60 h-60">
                            <canvas id="oldNewChart"></canvas>
                        </div>
                        <div class="w-60 h-60">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/4">
                    <div class="widget w-full h-full p-4 rounded-lg bg-white border border-gray-100 shadow dark:bg-gray-900 dark:border-gray-800">
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
                                        <div class="text-xs text-gray-500">{{ Carbon\Carbon::parse($enrollee->created_at)->format('F j') }}</div>
                                    </div>
                                    <div class="text-sm">{{ $enrollee->section->name ?? 'N/A' }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row w-full lg:space-x-2 space-y-2 lg:space-y-0 mb-2 lg:mb-4">
                <div class="flex flex-wrap w-full justify-around bg-white rounded-lg p-4 border border-gray-100 shadow overflow-hidden dark:bg-gray-900 dark:border-gray-800">
                    <canvas id="programChart" height="150"></canvas>
                </div>
            </div>
        </div>
         
        @include('partials.loading')
    </div>
   
 </div>