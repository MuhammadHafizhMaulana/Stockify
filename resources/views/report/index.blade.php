<x-layout>

    <div class="flex justify-center gap-6 my-6">
        <a href="{{ route('report.product.index') }}"
            class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">
            Product Report
        </a>

        <a href="{{ route('report.products.index') }}"
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">
            Keluar Masuk
        </a>

        <a href="#"
            class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">
            User
        </a>
    </div>

</x-layout>
