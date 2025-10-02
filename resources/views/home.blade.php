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

<body class="h-full overflow-hidden">
    <!-- Include this script tag or install `@tailwindplus/elements` via npm: -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script> -->
    <div class="absolute top-4 left-4 z-50">
        <img src="{{ $setting && $setting->logo ? asset('storage/' . $setting->logo) : asset('storage/assets/logo.jpeg') }}""
            alt="Logo" class="w-12 h-12">
    </div>
    <div class="bg-gray-900 h-full">
        <div class="relative isolate px-6 lg:px-8">
            <div aria-hidden="true"
                class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                    class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75">
                </div>
            </div>
            <div class="mx-auto max-w-2xl py-38 sm:py-48 lg:py-32">
                <div class="text-center">
                    <h1 class="text-5xl font-semibold tracking-tight text-balance text-white sm:text-7xl">
                        {{ $setting && $setting->title
                            ? ucwords($setting->title)
                            : 'Stockify
                                                                        Aplikasi Manajemen Gudang' }}
                    </h1>
                    <p class="mt-4 text-lg font-medium text-pretty text-gray-400 sm:text-xl/8">
                        {{ $setting && $setting->slogan
                            ? ucfirst($setting->slogan)
                            : 'Solusi cerdas untuk
                                                                        memantau stok, mengatur transaksi, dan menjaga gudang tetap terorganisir.' }}
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="{{ route('login') }}"
                            class="rounded-md bg-indigo-500 px-9.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 ">Login</a>
                        <a href="{{ route('register') }}" class="text-sm/6 font-semibold text-white">Don't have account,
                            register here <span aria-hidden="true">→</span></a>
                    </div>
                </div>
            </div>
            <div aria-hidden="true"
                class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                    class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75">
                </div>
            </div>
        </div>
    </div>



</body>

</html>
