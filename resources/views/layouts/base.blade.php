<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @hasSection('title')

            <title>@yield('title') - {{ config('app.name') }}</title>
        @else
            <title>{{ config('app.name') }}</title>
        @endif

        <!-- Favicon -->
		<link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        @wireUiScripts

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @livewireStyles
        @livewireScripts

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>

        <aside class="fixed bottom-2 right-2 group hover:opacity-100 transition-all bg-slate-400 p-1 rounded-lg drop-shadow-md overflow-hidden z-50 ">
            <x-badge white class="transition-all group-hover:-translate-y-full delay-100" icon="home" label="environment : {{ env('APP_ENV') }}" />
            @if (env('APP_DEBUG'))
                <br><x-badge rounded warning class="transition-all group-hover:translate-y-full delay-200" label="Debug Mode" />
            @endif
        </aside>

        @yield('body')

        @yield('script')


    </body>
</html>
