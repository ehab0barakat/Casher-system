<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Tailwind UI -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/ui@latest/dist/tailwind-ui.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2&display=swap" rel="stylesheet">




    {{--     FOR DATEPICKER    --}}

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" defer src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    
    @stack('styles')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles



</head>

<body dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}" class="overflow-y-hidden font-sans antialiased">

    <div class="min-h-screen bg-gray-100">

        @livewire('navigation.nav-admin')

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <x-notification />

    @stack('modals')

    @stack('scripts')

    @livewireScripts
</body>

</html>
