<div class="pt-5 px-4 lg:pl-5 w-full h-full overflow-y-auto scrolling-touch flex-1">
    <div class="w-full mb-6 pt-3">
        <div class="mb-4 pb-3 border-b-2">
            <div class="flex flex-row items-center justify-between">
                <div class="flex flex-col">
                    <div class="text-xl">{{ __('User Details')}}</div>
                    <div class="text-xs text-blue-500 font-semibold">Add Description</div>
                </div>
                <div class="flex-shrink-0 space-x-2">
                    <a href="{{route('admin.users.view')}}" class="focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 border border-gray-300 btn btn-default text-gray-500 py-2.5 px-4 font-bold text-xs rounded-lg">{{ __('See List')}}</a>
                </div>
            </div>
        </div>

        <div class="-my-2 overflow-x-auto">
            <div class="py-2 align-middle inline-block min-w-full ">
                @livewire('forms.user.user-form')
            </div>
        </div>
    </div>
</div>