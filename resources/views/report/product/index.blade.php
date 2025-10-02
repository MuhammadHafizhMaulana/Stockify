<x-layout>
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-xl p-3 mb-3 dark:bg-gray-700 dark:text-white dark:border-amber-50">
            <h1 class="text-2xl font-bold mb-6">Pilih Produk untuk Melihat Laporan</h1>

            {{-- Optional: Pencarian Produk --}}
            <form method="GET" class="mb-4">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama produk..."
                    class="border rounded p-2 w-1/2">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Cari</button>
            </form>
        </div>

        <div class="bg-white rounded-xl p-3 dark:bg-gray-700 dark: text-white dark:border-amber-50">

            {{-- Tabel Daftar Produk --}}
            <table class="w-full border mb-8 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-3">
                <thead class="text-xs text-white uppercase bg-blue-950 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="border px-2 py-1">Nama Produk</th>
                        <th class="border px-2 py-1">Kategori</th>
                        <th class="border px-2 py-1 text-center">Stok</th>
                        <th class="border px-2 py-1 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <td class="border px-2 py-1">{{ $product->name }}</td>
                            <td class="border px-2 py-1">{{ $product->category->name ?? '-' }}</td>
                            <td class="border px-2 py-1 text-center">{{ $product->current_stock ?? 0 }}</td>
                            <td class="border px-2 py-1 text-center">
                                {{-- Tombol ke halaman laporan detail --}}
                                <a href="{{ route('report.product.show', $product->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs shadow">
                                    Lihat Laporan
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <td colspan="4" class="border px-2 py-2 text-center text-gray-500">
                                Tidak ada produk
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Tombol Kembali --}}
            <div class="mt-6">
                <a href="{{ route('report.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    ← Kembali ke Halaman Report
                </a>
            </div>
        </div>
    </div>
</x-layout>
