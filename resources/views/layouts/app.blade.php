<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PT. Mirota KSM">
    <title>Mirota Landing</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<body class="bg-gray-50 text-gray-800" x-data="{ open: false }">

    <x-navbar />


    <main>
        @yield('content')
    </main>

    <x-footer />

</body>
</html>

