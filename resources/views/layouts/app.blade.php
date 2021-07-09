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
        <style>
            [x-cloak] {
                visibility: hidden !important;
                overflow: hidden !important;
            }
        </style>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        {{-- <link rel="stylesheet" href="{{ asset('css/main.css') }}"> --}}
        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        {{-- <script src="{{ asset('js/main.js') }}"></script> --}}
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" data-auto-replace-svg="nest"></script>
        
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        {{-- <div class="min-h-screen max-w-8xl flex flex-col bg-gray-100">
            <header class="top-0 left-0 fixed w-full z-40">
                @livewire('navigation-menu')
            </header>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="w-full mx-auto px-4 flex flex-row items-center">
                        <div class="relative mr-3 cursor-pointer px-3 py-2 rounded-full text-gray-500 hover:bg-gray-200 " title="back">
                            <i class="fas fa-arrow-left" title="back"></i>
                            <a href="{{ route('admin.dashboard')}}" class="absolute w-full h-full top-0 left-0"></a>
                        </div>
                        <div class="py-4">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="w-full">
                    @if (request()->is('admin/*') || request()->is('student/*'))
                        <div class="fixed left-0 top-12 overflow-hidden bg-black w-48 m-5 hidden lg:block rounded-md shadow-md h-full">
                            @include('sidebar')
                        </div>
                    @endif

                    {{ $slot }}
            </main>

            @include('partials.offline')
        </div>  --}}
        
        <div class="min-h-screen max-w-8xl flex flex-col bg-anti-flash">
            @livewire('navigation-menu')

            <main class="pt-12">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white shadow pl-0 lg:pl-14 pt-1">
                        <div class="w-full mx-auto px-4 flex flex-row items-center">
                            <div class="py-4">
                                {{ $header }}
                            </div>
                        </div>
                    </header>
                @endif

                <div class="pl-0 lg:pl-12">
                    {{ $slot }}
                </div>
            </main>
        </div>
        @include('partials.alerts')

        @stack('modals')
        @livewireScripts
    </body>
</html>
