<div class="pt-5 pl-5 lg:pl-0 w-full h-full overflow-y-auto scrolling-touch flex-1">
    <div class="w-full mb-6 pt-3">
        <div>
            <div class="flex flex-row items-top justify-between mb-4">
                <div class="flex flex-col">
                    <div class="text-xs uppercase font-light text-gramy-500">{{ __('OVERVIEW') }}</div>
                    <div class="text-xl font-bold">{{ __('Dashboard') }}</div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row w-full lg:space-x-2 space-y-2 lg:space-y-0 mb-2 lg:mb-4">
                <div class="w-full lg:w-1/4">
                    <div class="widget w-full p-4 rounded-lg bg-white border border-gray-100 dark:bg-gray-900 dark:border-gray-800">
                        <div class="flex flex-row items-center justify-between">
                            <div class="flex flex-col">
                                <div class="text-xs uppercase font-light text-gray-500">Users</div>
                                <div class="text-xl font-bold">588</div>
                            </div>
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="stroke-current text-gray-500" height="24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-1/4">
                    <div class="widget w-full p-4 rounded-lg bg-white border border-gray-100 dark:bg-gray-900 dark:border-gray-800">
                        <div class="flex flex-row items-center justify-between">
                            <div class="flex flex-col">
                                <div class="text-xs uppercase font-light text-gray-500">Sessions</div>
                                <div class="text-xl font-bold">435</div>
                            </div>
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="stroke-current text-gray-500" height="24" width="24" xmlns="http://www.w3.org/2000/svg"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-1/4">
                    <div class="widget w-full p-4 rounded-lg bg-white border border-gray-100 dark:bg-gray-900 dark:border-gray-800">
                        <div class="flex flex-row items-center justify-between">
                            <div class="flex flex-col">
                                <div class="text-xs uppercase font-light text-gray-500">Bounce Rate</div>
                                <div class="text-xl font-bold">40.5%</div>
                            </div>
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="stroke-current text-gray-500" height="24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-1/4">
                    <div class="widget w-full p-4 rounded-lg bg-white border border-gray-100 dark:bg-gray-900 dark:border-gray-800">
                        <div class="flex flex-row items-center justify-between">
                            <div class="flex flex-col">
                                <div class="text-xs uppercase font-light text-gray-500">Session duration</div>
                                <div class="text-xl font-bold">1m 24s</div>
                            </div>
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="stroke-current text-gray-500" height="24" width="24" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col lg:flex-row w-full lg:space-x-2 space-y-2 lg:space-y-0 mb-2 lg:mb-4">
                <div class="w-full lg:w-3/4">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto">
                            <div class="py-2 align-middle inline-block min-w-full ">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Title
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Role
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Action
                                                </th>
                                                {{-- <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Edit</span>
                                                </th> --}}
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=60" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        Jane Cooper
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        jane.cooper@example.com
                                                    </div>
                                                    </div>
                                                </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Regional Paradigm Technician</div>
                                                <div class="text-sm text-gray-500">Optimization</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                Admin
                                                </td>
                                                <td class="whitespace-nowrap text-center text-sm font-medium">
                                                {{-- <a href="#" class="px-2 py-2 text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <a href="#" class="px-2 py-2 text-red-600 hover:text-red-900">Delete</a> --}}
                                                <button class="text-blue-500 hover:text-white hover:bg-blue-500  hover:text-xs text-sm px-1.5 py-1 rounded-full hover:shadow-md outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" title="edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-red-500 hover:text-white hover:bg-red-500  hover:text-xs text-sm px-2 py-1 rounded-full hover:shadow-md outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" title="delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=60" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        Jane Cooper
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        jane.cooper@example.com
                                                    </div>
                                                    </div>
                                                </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Regional Paradigm Technician</div>
                                                <div class="text-sm text-gray-500">Optimization</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                Admin
                                                </td>
                                                <td class="whitespace-nowrap text-center text-sm font-medium">
                                                {{-- <a href="#" class="px-2 py-2 text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <a href="#" class="px-2 py-2 text-red-600 hover:text-red-900">Delete</a> --}}
                                                <button class="text-blue-500 hover:text-white hover:bg-blue-500  hover:text-xs text-sm px-1.5 py-1 rounded-full hover:shadow-md outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" title="edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-red-500 hover:text-white hover:bg-red-500  hover:text-xs text-sm px-2 py-1 rounded-full hover:shadow-md outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" title="delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=60" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        Jane Cooper
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        jane.cooper@example.com
                                                    </div>
                                                    </div>
                                                </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Regional Paradigm Technician</div>
                                                <div class="text-sm text-gray-500">Optimization</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                Admin
                                                </td>
                                                <td class="whitespace-nowrap text-center text-sm font-medium">
                                                {{-- <a href="#" class="px-2 py-2 text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <a href="#" class="px-2 py-2 text-red-600 hover:text-red-900">Delete</a> --}}
                                                <button class="text-blue-500 hover:text-white hover:bg-blue-500  hover:text-xs text-sm px-1.5 py-1 rounded-full hover:shadow-md outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" title="edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-red-500 hover:text-white hover:bg-red-500  hover:text-xs text-sm px-2 py-1 rounded-full hover:shadow-md outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" title="delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=60" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        Jane Cooper
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        jane.cooper@example.com
                                                    </div>
                                                    </div>
                                                </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Regional Paradigm Technician</div>
                                                <div class="text-sm text-gray-500">Optimization</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                Admin
                                                </td>
                                                <td class="whitespace-nowrap text-center text-sm font-medium">
                                                {{-- <a href="#" class="px-2 py-2 text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <a href="#" class="px-2 py-2 text-red-600 hover:text-red-900">Delete</a> --}}
                                                <button class="text-blue-500 hover:text-white hover:bg-blue-500  hover:text-xs text-sm px-1.5 py-1 rounded-full hover:shadow-md outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" title="edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-red-500 hover:text-white hover:bg-red-500  hover:text-xs text-sm px-2 py-1 rounded-full hover:shadow-md outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" title="delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=60" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        Jane Cooper
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        jane.cooper@example.com
                                                    </div>
                                                    </div>
                                                </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Regional Paradigm Technician</div>
                                                <div class="text-sm text-gray-500">Optimization</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                Admin
                                                </td>
                                                <td class="whitespace-nowrap text-center text-sm font-medium">
                                                {{-- <a href="#" class="px-2 py-2 text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <a href="#" class="px-2 py-2 text-red-600 hover:text-red-900">Delete</a> --}}
                                                <button class="text-blue-500 hover:text-white hover:bg-blue-500  hover:text-xs text-sm px-1.5 py-1 rounded-full hover:shadow-md outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" title="edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-red-500 hover:text-white hover:bg-red-500  hover:text-xs text-sm px-2 py-1 rounded-full hover:shadow-md outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" title="delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=60" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        Jane Cooper
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        jane.cooper@example.com
                                                    </div>
                                                    </div>
                                                </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Regional Paradigm Technician</div>
                                                <div class="text-sm text-gray-500">Optimization</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                Admin
                                                </td>
                                                <td class="whitespace-nowrap text-center text-sm font-medium">
                                                {{-- <a href="#" class="px-2 py-2 text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <a href="#" class="px-2 py-2 text-red-600 hover:text-red-900">Delete</a> --}}
                                                <button class="text-blue-500 hover:text-white hover:bg-blue-500  hover:text-xs text-sm px-1.5 py-1 rounded-full hover:shadow-md outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" title="edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-red-500 hover:text-white hover:bg-red-500  hover:text-xs text-sm px-2 py-1 rounded-full hover:shadow-md outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" title="delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- This example requires Tailwind CSS v2.0+ -->
                                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                                        <div class="flex-1 flex justify-between sm:hidden">
                                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
                                            Previous
                                        </a>
                                        <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
                                            Next
                                        </a>
                                        </div>
                                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm text-gray-700">
                                            Showing
                                            <span class="font-medium">1</span>
                                            to
                                            <span class="font-medium">10</span>
                                            of
                                            <span class="font-medium">97</span>
                                            results
                                            </p>
                                        </div>
                                        <div>
                                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                                <span class="sr-only">Previous</span>
                                                <!-- Heroicon name: solid/chevron-left -->
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                1
                                            </a>
                                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                2
                                            </a>
                                            <a href="#" class="hidden md:inline-flex relative items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                3
                                            </a>
                                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                                ...
                                            </span>
                                            <a href="#" class="hidden md:inline-flex relative items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                8
                                            </a>
                                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                9
                                            </a>
                                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                10
                                            </a>
                                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                                <span class="sr-only">Next</span>
                                                <!-- Heroicon name: solid/chevron-right -->
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            </nav>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-1/4">
                    <div class="widget w-full p-4 rounded-lg bg-white border border-gray-100 dark:bg-gray-900 dark:border-gray-800">
                        <div class="flex flex-row justify-between mb-6">
                            <div class="flex flex-col">
                                <div class="text-sm font-light text-gray-500">Recently Enrolled</div>
                                <div class="text-sm font-bold"><span>This week</span></div>
                            </div>
                            <div class="mt-2 text-gray-400 hover:text-green-500 cursor-pointer">
                                <i class="fas fa-redo-alt"></i>
                            </div>
                        </div>
                        <div class="flex items-center justify-start p-2 space-x-4 mb-5">
                            <div class="flex-shrink-0 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=60" alt="">
                            </div>
                            <div class="flex flex-col w-full">
                                <div class="flex flex-row justify-between text-sm font-bold">
                                    <div>Jane Cooper</div>
                                    <div class="text-xs text-gray-500">Feb. 29</div>
                                </div>
                                <div class="text-sm">BSIT - 3E</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-start p-2 space-x-4 mb-5">
                            <div class="flex-shrink-0 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=60" alt="">
                            </div>
                            <div class="flex flex-col w-full">
                                <div class="flex flex-row justify-between text-sm font-bold">
                                    <div>Jane Cooper</div>
                                    <div class="text-xs text-gray-500">Feb. 29</div>
                                </div>
                                <div class="text-sm">BSIT - 3E</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-start p-2 space-x-4 mb-5">
                            <div class="flex-shrink-0 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=60" alt="">
                            </div>
                            <div class="flex flex-col w-full">
                                <div class="flex flex-row justify-between text-sm font-bold">
                                    <div>Jane Cooper</div>
                                    <div class="text-xs text-gray-500">Feb. 29</div>
                                </div>
                                <div class="text-sm">BSIT - 3E</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-start p-2 space-x-4 mb-5">
                            <div class="flex-shrink-0 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=60" alt="">
                            </div>
                            <div class="flex flex-col w-full">
                                <div class="flex flex-row justify-between text-sm font-bold">
                                    <div>Jane Cooper</div>
                                    <div class="text-xs text-gray-500">Feb. 29</div>
                                </div>
                                <div class="text-sm">BSIT - 3E</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         
        @include('partials.loading')
    </div>
   
 </div>