<x-layout>
    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">Laporan Produk: {{ $product->name }}</h1>
                <p class="text-gray-600 text-sm">
                    Periode: {{ $data['periode'][0] }} s/d {{ $data['periode'][1] }}
                </p>
            </div>
            <div class="space-x-2">
                {{-- Tombol export PDF & Excel --}}
                <a href="{{ route('report.product.pdf', ['product' => $product->id] + request()->query()) }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm">Export PDF</a>
                <a href="{{ route('report.product.excel', ['product' => $product->id] + request()->query()) }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-sm">Export Excel</a>
            </div>
        </div>

        {{-- Filter Periode --}}
        <form method="GET" class="mb-6 flex gap-2">
            <input type="date" name="start_date" value="{{ request('start_date', $data['periode'][0]) }}"
                class="border rounded p-2">
            <input type="date" name="end_date" value="{{ request('end_date', $data['periode'][1]) }}"
                class="border rounded p-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Terapkan</button>
        </form>

        {{-- Tabel Laporan --}}
        <div class="overflow-x-auto">
            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2">Tanggal</th>
                        <th class="border px-3 py-2">Jenis Transaksi</th>
                        <th class="border px-3 py-2 text-right">Jumlah</th>
                        <th class="border px-3 py-2 text-right">Status</th>
                        <th class="border px-3 py-2">Keterangan</th>
                        <th class="border px-3 py-2">Inputor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['details'] as $row)
                        <tr>
                            <td class="border px-3 py-2">{{ $row->created_at ?? '-' }}</td>
                            <td class="border px-3 py-2 capitalize">{{ $row->type ?? '-' }}</td>
                            <td class="border px-3 py-2 text-right">{{ $row->quantity ?? 0 }}</td>
                            <td class="border px-3 py-2 text-right">{{ $row->status ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $row->notes ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $row->user->name . '/' . $row->user->role ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border px-3 py-4 text-center text-gray-500">
                                Tidak ada transaksi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-6">
            <a href="{{ route('report.product.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                ← Kembali ke Daftar Produk
            </a>
        </div>

    </div>
</x-layout>
