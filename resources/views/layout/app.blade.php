<!doctype html>
<html data-theme="winter" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>{{ config('app.name') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"  />
</head>
<body class="bg-gray-50 antialiased text-gray-700">
@auth
    @include('layout.navbar')
@endauth
<div class="container mx-auto min-h-screen">
    <div class="px-6">
        @yield('content')
    </div>
</div>
</body>
</html>
