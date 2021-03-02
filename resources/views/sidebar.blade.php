<div x-on:click="sidebarBtn = ! sidebarBtn" class="p-5 flex flex-row justify-between items-center h-8 relative hover:bg-gray-50 cursor-pointer">
  <div :class="{'block': sidebarBtn, 'hidden': ! sidebarBtn}" class="text-sm font-light tracking-wide text-gray-500 font-bold">
    @if (Auth::user()->role->name === 'admin')
      Admin
    @else
      Student
    @endif
  </div>
  <div>
    <svg :class="{'block': sidebarBtn, 'hidden': ! sidebarBtn}" viewBox="0 0 1024 517" aria-labelledby="bnsi-ant-circle-o-left-title" class="w-4">
      <path d="M282 508q9-9 9-22.5t-9-22.5L110 291h882q13 0 22.5-9.5t9.5-22.5-9.5-22.5T992 227H109L281 55q10-9 10-22.5T281 10q-9-10-22.5-10T236 10L9 236q-9 9-9 22.5T9 281l228 227q9 9 22.5 9t22.5-9z"></path>
    </svg>
    <svg :class="{'hidden': sidebarBtn, 'block': ! sidebarBtn}" class="w-4" viewBox="0 0 1024 517">
      <path d="M742 508q-9-9-9-22.5t9-22.5l172-172H32q-13 0-22.5-9.5T0 259t9.5-22.5T32 227h883L743 55q-10-9-10-22.5T743 10q9-10 22.5-10T788 10l227 226q9 9 9 22.5t-9 22.5L787 508q-9 9-22.5 9t-22.5-9z"></path>
    </svg>
  </div>
</div>

<ul x-data="{tab: 'selected-1'}" class="flex flex-col space-y-1 h-full w-full overflow-y-auto scrolling-touch overflow-x-hidden">
  <li @click="tab = 'selected-1'">
    <a href="#" :class="{'border-indigo-500 text-indigo-500 ': tab === 'selected-1'}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 text-gray-800 border-l-4 border-transparent pr-6 hover:text-indigo-500">
      <span class="inline-flex justify-center items-center ml-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
      </span>
      <span class="ml-3 text-sm tracking-wide truncate">Dashboard</span>
    </a>
  </li>

  <li @click="tab = 'selected-2'">
    <a href="#" :class="{'border-indigo-500 text-indigo-500': tab === 'selected-2'}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 text-gray-800 border-l-4 border-transparent pr-6 hover:text-indigo-500">
      <span class="inline-flex justify-center items-center ml-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
      </span>
      <span class="ml-3 text-sm tracking-wide truncate">Master List</span>
    </a>
  </li>

  <li @click="tab = 'selected-3'">
    <a href="#" :class="{'border-indigo-500 text-indigo-500': tab === 'selected-3'}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 text-gray-800 border-l-4 border-transparent pr-6 hover:text-indigo-500">
      <span class="inline-flex justify-center items-center ml-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
      </span>
      <span class="ml-3 text-sm tracking-wide truncate">Master List</span>
    </a>
  </li>

  <li @click="tab = 'selected-4'">
    <a href="#" :class="{'border-indigo-500 text-indigo-500': tab === 'selected-4'}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 text-gray-800 border-l-4 border-transparent pr-6 hover:text-indigo-500">
      <span class="inline-flex justify-center items-center ml-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
      </span>
      <span class="ml-3 text-sm tracking-wide truncate">Master List</span>
    </a>
  </li>

  <li @click="tab = 'selected-5'">
    <a href="#" :class="{'border-indigo-500 text-indigo-500': tab === 'selected-5'}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 text-gray-800 border-l-4 border-transparent pr-6 hover:text-indigo-500">
      <span class="inline-flex justify-center items-center ml-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
      </span>
      <span class="ml-3 text-sm tracking-wide truncate">Master List</span>
    </a>
  </li>
</ul>