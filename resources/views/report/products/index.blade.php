<x-layout>
    <div class="max-w-6xl mx-auto">
        <div class="bg-white p-3 mb-3 rounded-xl dark:bg-gray-700 dark: text-white dark:border-amber-50">
            <h1 class="text-2xl font-bold mb-4">Laporan Keluar-Masuk Produk</h1>

            {{-- Filter Periode --}}
            <form method="GET" class="mb-6 flex gap-2">
                <input type="date" name="start_date" value="{{ request('start_date', $data['periode'][0]) }}"
                    class="border rounded p-2">
                <input type="date" name="end_date" value="{{ request('end_date', $data['periode'][1]) }}"
                    class="border rounded p-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Terapkan</button>
            </form>

            {{-- Tombol Export --}}
            <div class="mb-4 flex gap-3">
                <a href="{{ route('report.products.pdf', request()->query()) }}"
                    class="bg-red-500 text-white px-4 py-2 rounded">Export PDF</a>
                <a href="{{ route('report.products.excel', request()->query()) }}"
                    class="bg-green-600 text-white px-4 py-2 rounded">Export Excel</a>
            </div>
        </div>

        <div class="bg-white rounded-xl p-3 dark:bg-gray-700 dark: text-white dark:border-amber-50">

            {{-- Ringkasan --}}
            <table class="w-full border mb-8 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-3">
                <thead class="text-xs text-white uppercase bg-blue-950 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="border px-2 py-1">Produk</th>
                        <th class="border px-2 py-1">Total Masuk</th>
                        <th class="border px-2 py-1">Total Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data['summary'] as $row)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <td class="border px-2 py-1">{{ $row->product->name }}</td>
                            <td class="border px-2 py-1 text-center">{{ $row->total_masuk }}</td>
                            <td class="border px-2 py-1 text-center">{{ $row->total_keluar }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-3 text-gray-500 dark:text-gray-400">
                                Belum ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Detail transaksi --}}
            <h2 class="text-xl font-semibold mb-2">Detail Transaksi</h2>
            <table class="w-full border mb-8 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-white uppercase bg-blue-950 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="border px-2 py-1">Tanggal</th>
                        <th class="border px-2 py-1">Produk</th>
                        <th class="border px-2 py-1">Jenis</th>
                        <th class="border px-2 py-1">Qty</th>
                        <th class="border px-2 py-1">Status</th>
                        <th class="border px-2 py-1">Inputor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data['details'] as $trx)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <td class="border px-2 py-1">{{ $trx->updated_at }}</td>
                            <td class="border px-2 py-1">{{ ucwords($trx->product->name) }}</td>
                            <td class="border px-2 py-1 capitalize">{{ ucfirst($trx->type) }}</td>
                            <td class="border px-2 py-1 text-center">{{ $trx->quantity }}</td>
                            <td class="border px-2 py-1 text-center">{{ ucfirst($trx->status) }}</td>
                            <td class="border px-2 py-1">{{ ucwords($trx->user->name) . '/' . $trx->user->role }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-gray-500 dark:text-gray-400">
                                Belum ada data
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
