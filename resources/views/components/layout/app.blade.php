<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>{{ env('APP_NAME') . $title }}</title>
    
    <script src="{{ asset('asset/vendor/fontawsome.js') }}"></script>
    <script src="{{ asset('asset/vendor/jquery.js') }}"></script>
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body @if($class) class="{{ $class }}" @endif>
    <x-alert />
    {{ $slot }}
    @livewireScripts
    @stack('scripts')
</body>
</html>