<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="container mx-auto">
        <div class="px-6 mt-8">
            @yield('content')
        </div>
    </div>
</body>
</html>
