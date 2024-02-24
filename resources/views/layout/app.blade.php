<!doctype html>
<html data-theme="winter" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>{{ config('app.name') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<body class="bg-gray-50 antialiased text-gray-700">
@include('layout.navbar')
<div class="container mx-auto min-h-screen">
    <div class="my-8 px-6">
        @yield('content')
    </div>
</div>
</body>
</html>
