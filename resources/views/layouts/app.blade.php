<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta property="og:image" content="{{ $school_profile_photo_path }}">
        <meta property="og:image:type" content="image/jpeg">
        <meta property="og:image:width" content="200">
        <meta property="og:image:height" content="200">
        <meta property="og:description" content="{{ filled($school_email) ? 'Email us @ '.$school_email : config('app.name', 'Laravel') }}">
        <link rel="icon" href="{{ $school_profile_photo_path }}">
        <title>{{ $school_name ?? config('app.name', 'Laravel') }}</title>

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
        @stack('styles')

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>

        {{-- <script src="{{ asset('js/main.js') }}"></script> --}}
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" data-auto-replace-svg="nest"></script>
        <!-- Alpine JS-->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />
        {{-- @include('partials.offline') --}}

        <div class="min-h-screen max-w-8xl flex flex-col bg-anti-flash">
            @livewire('navigation-menu')

            <main class="pt-12">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white shadow pl-0 lg:pl-14 pt-1 bg-red-900">
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

        <livewire:partials.job-batching-progress-tracker-component/>

        @stack('modals')
        @livewireScripts
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>
            window.addEventListener('swal:modal', event => {
                swal({
                    title: event.detail.title,
                    text: event.detail.text,
                    icon: event.detail.type,
                });
            });

            window.addEventListener('swal:confirm', event => {
                swal({
                    title: event.detail.title,
                    text: event.detail.text,
                    icon: event.detail.type,
                    buttons: true,
                    dangerMode: true,
                })
                .then((willConfirm) => {
                    if(! willConfirm) return;

                    if(willConfirm && event.detail.item) return window.livewire.emit(event.detail.method, event.detail.item);

                    return window.livewire.emit(event.detail.method);
                });
            });
        </script>

        @if(session()->has('swal:modal'))
            <script>
                window.onload = function() {
                    swal({
                        title: '{{ session("swal:modal")['title'] }}',
                        text: '{{ session("swal:modal")['text'] }}',
                        icon: '{{ session("swal:modal")['type'] }}',
                    });
                };
            </script>
        @endif

        @stack('scripts')

        <script>
            window.addEventListener('refresh-page', event => {
                alert(event.detail.message) ? "" : location.reload();
            });

            window.addEventListener('DOMContentLoaded', function() {
                const userId = '{{auth()->user()->id}}';

                function refreshNotificationComponents() {
                    window.livewire.emit('refresh-notification-component:'+userId);
                    window.livewire.emit('refresh-user-notification-component:'+userId);
                }

                Echo.private('notification-updated-count.'+userId)
                    .listen('NotificationUpdatedCount', (e) => {
                        refreshNotificationComponents();
                        window.livewire.emit('form-payment-index-component:'+userId);
                    });

                Echo.private('notification.'+userId)
                    .listen('CreateNotification', (e) => {
                        refreshNotificationComponents();
                    });
            });
        </script>
    </body>
</html>
