<!doctype html>
<html data-theme="winter" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>{{ config('app.name') }}</title>
</head>
<body class="bg-gray-50 antialiased text-gray-700">
    @include('layout.navbar')
    <div class="container mx-auto min-h-screen">
        <div class="my-4 py-12 bg-white rounded-md shadow">
            @yield('content')
        </div>
    </div>
</body>
</html>
