<x-layout>
    <div class="max-w-5xl mx-auto my-10 px-4">
        <!-- Card Besar -->
        <div class="bg-transparent dark:bg-transparent rounded-2xl shadow-xl p-8 h-4/6">
            <h1 class="text-2xl font-bold text-center mb-8 text-gray-800 dark:text-gray-100">
                Laporan &amp; Monitoring
            </h1>

            <!-- Grid 3 kolom di desktop, 1 kolom di mobile -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Menu 1 -->
                <a href="{{ route('report.product.index') }}"
                    class="flex flex-col justify-center items-center text-center rounded-xl p-8 h-40
                          bg-gradient-to-br from-red-500 to-red-600
                          text-white font-semibold shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
                    <span class="text-lg">Product Report</span>
                </a>

                <!-- Menu 2 -->
                <a href="{{ route('report.products.index') }}"
                    class="flex flex-col justify-center items-center text-center rounded-xl p-8 h-40
                          bg-gradient-to-br from-blue-500 to-blue-600
                          text-white font-semibold shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
                    <span class="text-lg">Keluar Masuk</span>
                </a>

                <!-- Menu 3 -->
                <a href="{{ route('report.users.index') }}"
                    class="flex flex-col justify-center items-center text-center rounded-xl p-8 h-40
                          bg-gradient-to-br from-green-500 to-green-600
                          text-white font-semibold shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
                    <span class="text-lg">User</span>
                </a>
            </div>
        </div>
    </div>
</x-layout>
