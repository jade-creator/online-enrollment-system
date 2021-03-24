<div class="flex-shrink-0 flex items-center bg-primary">
  <a href="{{ route('admin.dashboard') }}">
      <x-jet-application-mark class="block h-9 w-auto" />
  </a>
  <p class="pl-2 text-white font-bold">{{ __('University') }}</p>
</div>

<div class="m-2 p-5 h-8 relative" >
  <div class="text-xs tracking-wide text-gray-400 font-bold">
    @if (Auth::user()->role->name === 'admin')
      {{ __('ADMIN') }}
    @else
      {{ __('STUDENT') }}
    @endif
  </div>
</div>

<ul class="flex flex-col space-y-1 h-full w-full overflow-y-auto scrolling-touch overflow-x-hidden sidebar">
  <li>
    <a href="{{route('admin.dashboard')}}" class="{{ request()->is('admin/dashboard') ? 'font-bold border-indigo-500 text-indigo-500 bg-gray-100' : 'text-gray-800'}} relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 border-l-4 border-transparent pr-6 hover:text-indigo-500">
      <span class="inline-flex justify-center items-center ml-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
      </span>
      <span class="ml-3 text-sm tracking-wide truncate">{{ __('Dashboard') }}</span>
    </a>
  </li>

  <li>
    <a href="{{route('admin.masterlist')}}" class="{{ request()->is('admin/masterlist') ? 'font-bold border-indigo-500 text-indigo-500 bg-gray-100' : 'text-gray-800'}} relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 border-l-4 border-transparent pr-6 hover:text-indigo-500">
      <span class="inline-flex justify-center items-center ml-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
      </span>
      <span class="ml-3 text-sm tracking-wide truncate">{{ __('Masterlist') }}</span>
    </a>
  </li>

  <li>
    <a href="#" class="{{ request()->is('admin/program') ? 'font-bold border-indigo-500 text-indigo-500 bg-gray-100' : 'text-gray-800'}} relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 border-l-4 border-transparent pr-6 hover:text-indigo-500">
      <span class="inline-flex justify-center items-center ml-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
      </span>
      <span class="ml-3 text-sm tracking-wide truncate">{{ __('Program') }}</span>
    </a>
  </li>

  <li>
    <a href="#" class="{{ request()->is('admin/course') ? 'font-bold border-indigo-500 text-indigo-500 bg-gray-100' : 'text-gray-800'}} relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 border-l-4 border-transparent pr-6 hover:text-indigo-500">
      <span class="inline-flex justify-center items-center ml-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
      </span>
      <span class="ml-3 text-sm tracking-wide truncate">Master List</span>
    </a>
  </li>

  <li>
    <a href="#" class="{{ request()->is('admin/admin') ? 'font-bold border-indigo-500 text-indigo-500 bg-gray-100' : 'text-gray-800'}} relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 border-l-4 border-transparent pr-6 hover:text-indigo-500">
      <span class="inline-flex justify-center items-center ml-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
      </span>
      <span class="ml-3 text-sm tracking-wide truncate">Master List</span>
    </a>
  </li>

</ul>