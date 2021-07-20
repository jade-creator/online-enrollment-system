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
                display: none !important;
            }
        </style>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        {{-- <script src="{{ asset('js/main.js') }}"></script> --}}
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" data-auto-replace-svg="nest"></script>
        <!-- Alpine JS-->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />
        {{-- @include('partials.offline') --}}
        
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

        @stack('modals')
        @livewireScripts
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>
            window.addEventListener('swal:successEnroll', event => {
                swal(event.detail.text, {
                    icon: "success",
                });
                window.livewire.emit('toggleEnrollingStudent');
            });

            window.addEventListener('swal:success', event => {
                swal(event.detail.text, {
                    icon: "success",
                });
            });

            window.addEventListener('swal:modal', event => {
                swal({
                    title: event.detail.title,
                    text: event.detail.text,
                    icon: event.detail.type,
                });
            });

            window.addEventListener('swal:confirmReject', event => {
                swal({
                    title: event.detail.title,
                    text: event.detail.text,
                    icon: event.detail.type,
                    buttons: true,
                    dangerMode: true,
                })
                .then((willReject) => {
                    if (willReject) {
                        window.livewire.emit('reject');
                    }
                });
            });

            window.addEventListener('swal:confirmDelete', event => {
                swal({
                    title: event.detail.title,
                    text: event.detail.text,
                    icon: event.detail.type,
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.livewire.emit('removeItem');
                    }
                });
            });

            window.addEventListener('swal:confirmRelease', event => {
                swal({
                    title: event.detail.title,
                    text: event.detail.text,
                    icon: event.detail.type,
                    buttons: true,
                    dangerMode: true,
                })
                .then((willRelease) => {
                    if (willRelease) {
                        window.livewire.emit('releaseStudents');
                    }
                });
            });
        </script>
    </body>
</html>
