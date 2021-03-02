<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" data-auto-replace-svg="nest"></script>
        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="h-screen flex flex-col bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow overflow-hidden flex flex-row">
                    <div x-data="{sidebarBtn: true}" :class="{'w-64': sidebarBtn, 'w-16 border-r-2 border-indigo-100': ! sidebarBtn}" class="h-full hidden md:block bg-gray-100 shadow-md relative transition-width transition-slowest ease">
                        @include('sidebar')
                    </div>
                    {{ $slot }}
            </main>
            <div class="absolute bottom-0 w-full bg-transparent md:py-4 md:px-4" wire:offline>
                <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none md:rounded-full flex md:inline-flex" role="alert">
                  <span class="flex rounded-full bg-indigo-500 uppercase px-1 py-1 text-md font-bold mr-3"><i class="fas fa-exclamation-circle"></i></span>
                  <span class="font-semibold mr-2 text-left flex-auto">You're in offline mode.</span>
                </div>
            </div>
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>
