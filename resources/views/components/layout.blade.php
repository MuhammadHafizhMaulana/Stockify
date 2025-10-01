<!DOCTYPE html class="h-full bg-gray-900">
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Document</title>
    <script defer src="//unpkg.com/alpinejs"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
</head>

<body
    class="min-h-screen bg-gradient-to-tr from-purple-300 via-indigo-200 to-purple-100 dark:from-purple-950 dark:via-indigo-800 dark:to-purple-700">
    <div class="min-h-full">
        <x-navbar></x-navbar>
        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
