@if (session()->has('alert'))
    <div x-data="{ open: true }" :class="{'hidden': ! open, 'block': open }" class="z-20 border border-gray-200 bg-white rounded-md fixed top-16 right-4 shadow-xl">
        <div class="p-5 flex flex-row items-start" role="alert">
            @if (session('alert.type') == 'success')
                <x-alert-save :title="session('alert.title')" :data="session('alert.data')" :message="session('alert.message')"/>
            @endif

            @if (session('alert.type') == 'error')
                <x-alert-error :title="session('alert.title')" :message="session('alert.message')"/>
            @endif
        </div>
    </div>
@endif