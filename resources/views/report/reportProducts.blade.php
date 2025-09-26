<x-layout>
    <div class="max-w-6xl mx-auto">
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
            <a href="{{ route('report.export.pdf', request()->query()) }}"
                class="bg-red-500 text-white px-4 py-2 rounded">Export PDF</a>
            {{-- <a href="{{ route('report.export.excel', request()->query()) }}"
        class="bg-green-600 text-white px-4 py-2 rounded">Export Excel</a> --}}
        </div>

        {{-- Ringkasan --}}
        <table class="w-full border mb-8 text-sm">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-2 py-1">Produk</th>
                    <th class="border px-2 py-1">Total Masuk</th>
                    <th class="border px-2 py-1">Total Keluar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['summary'] as $row)
                    <tr>
                        <td class="border px-2 py-1">{{ $row->product->name }}</td>
                        <td class="border px-2 py-1 text-center">{{ $row->total_masuk }}</td>
                        <td class="border px-2 py-1 text-center">{{ $row->total_keluar }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Detail transaksi --}}
        <h2 class="text-xl font-semibold mb-2">Detail Transaksi</h2>
        <table class="w-full border text-sm">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-2 py-1">Tanggal</th>
                    <th class="border px-2 py-1">Produk</th>
                    <th class="border px-2 py-1">Jenis</th>
                    <th class="border px-2 py-1">Qty</th>
                    <th class="border px-2 py-1">User</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['details'] as $trx)
                    <tr>
                        <td class="border px-2 py-1">{{ $trx->updated_at }}</td>
                        <td class="border px-2 py-1">{{ $trx->product->name }}</td>
                        <td class="border px-2 py-1 capitalize">{{ $trx->type }}</td>
                        <td class="border px-2 py-1 text-center">{{ $trx->quantity }}</td>
                        <td class="border px-2 py-1">{{ $trx->user->name . '/' . $trx->user->role }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
