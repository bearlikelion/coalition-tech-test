<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Page Title' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles()
    </head>
    <body class="bg-gray-100 min-h-screen flex flex-col">        
        <div class="flex flex-col min-h-screen">
            {{-- @include('components.layouts.navbar') --}}

            <main class="flex-grow container mx-auto px-4 py-6">
                {{ $slot }}
            </main>

            {{-- @include('components.layouts.footer') --}}
        </div>
        @livewireScripts()
    </body>
</html>