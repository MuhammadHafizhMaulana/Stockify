<x-layout>
    {{-- Dashboard Admin --}}
    @if (Auth::user()->role === 'admin')
        <div class="container mx-auto p-6 space-y-6">
            <form method="GET" action="{{ route('dashboard') }}"
                class="bg-white rounded-2xl shadow p-6 mb-6 flex flex-col md:flex-row items-end gap-4">

                <div class="flex-1">
                    <label for="start_date" class="block text-sm font-medium text-gray-600 mb-1">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $start }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="flex-1">
                    <label for="end_date" class="block text-sm font-medium text-gray-600 mb-1">Tanggal Akhir</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $end }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
                        Filter
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg shadow transition">
                        Reset
                    </a>
                </div>
            </form>



            {{-- Ringkasan --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-blue-500">
                    <h2 class="text-gray-500">Jumlah Produk</h2>
                    <p class="text-3xl font-bold">{{ $totalProduct }}</p>
                </div>

                <div class="bg-green-50 rounded-2xl shadow p-6 border-l-4 border-green-600">
                    <h2 class="text-gray-700">Transaksi Masuk</h2>
                    <p class="text-3xl font-bold text-green-700">{{ $transaksiMasuk }}</p>
                </div>

                <div class="bg-red-50 rounded-2xl shadow p-6 border-l-4 border-red-600">
                    <h2 class="text-gray-700">Transaksi Keluar</h2>
                    <p class="text-3xl font-bold text-red-700">{{ $transaksiKeluar }}</p>
                </div>

                <div class="bg-yellow-50 rounded-2xl shadow p-6 border-l-4 border-yellow-600">
                    <h2 class="text-gray-700">Transaksi Pending</h2>
                    <p class="text-3xl font-bold text-yellow-700">{{ $pendingTransactions ?? 0 }}</p>
                </div>
            </div>

            {{-- Grafik + Stok Menipis --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-lg font-semibold mb-4">Grafik Stok Barang (Top 10)</h2>
                    <canvas id="stokChart"></canvas>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-lg font-semibold mb-4">Stok Menipis</h2>
                    <ul class="divide-y divide-gray-200">
                        @forelse ($lowStock as $item)
                            <li class="py-2 flex justify-between">
                                <span>{{ $item->name }} (SKU: {{ $item->sku }})</span>
                                <span class="text-red-600 font-semibold">{{ $item->current_stock }}</span>
                            </li>
                        @empty
                            <p class="text-gray-500 text-sm">Tidak ada stok menipis</p>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- Aktivitas Terbaru --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Aktivitas Pengguna Terbaru</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
                        <thead class="bg-gray-100 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">Waktu</th>
                                <th class="px-4 py-2">User</th>
                                <th class="px-4 py-2">Aksi</th>
                                <th class="px-4 py-2">Deskripsi</th>
                                <th class="px-4 py-2">IP / Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activity as $index => $log)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2">{{ $log->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-2">
                                        {{ $log->user->name ?? 'Unknown' }}/{{ $log->user->role ?? '-' }}<br>
                                        <span class="text-xs text-gray-500">{{ $log->user->email ?? '-' }}</span>
                                    </td>
                                    <td class="px-4 py-2">{{ $log->action ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $log->description }}</td>
                                    <td class="px-4 py-2">
                                        {{ $log->ip_address ?? '-' }}<br>
                                        <span class="text-xs text-gray-500">{{ $log->user_agent ?? '-' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-2 text-center text-gray-500">
                                        Belum ada aktivitas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Script Grafik --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('stokChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($productLabels),
                    datasets: [{
                        label: 'Stok Barang',
                        data: @json($productStock),
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endif


    @if (Auth::user()->role === 'manajer')

        <div class="p-6 space-y-6">

            {{-- Ringkasan Angka --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="p-4 bg-blue-100 rounded-xl shadow text-center border-l-4 border-blue-400 ">
                    <h2 class="text-lg font-semibold">Jumlah Produk</h2>
                    <p class="text-2xl font-bold text-blue-700">{{ $totalProduct }}</p>
                </div>
                <div class="p-4 bg-green-100 rounded-xl shadow text-center border-l-4 border-green-400">
                    <h2 class="text-lg font-semibold">Transaksi Masuk (24 jam)</h2>
                    <p class="text-2xl font-bold text-green-700">{{ $barangMasuk->count() }}</p>
                </div>
                <div class="p-4 bg-red-100 rounded-xl shadow text-center border-l-4 border-red-400">
                    <h2 class="text-lg font-semibold ">Transaksi Keluar (24 jam)</h2>
                    <p class="text-2xl font-bold text-red-700">{{ $barangKeluar->count() }}</p>
                </div>
                <div class="p-4 bg-yellow-100 rounded-xl shadow text-center border-l-4 border-yellow-400">
                    <h2 class="text-lg font-semibold">Pending Approval</h2>
                    <p class="text-2xl font-bold text-yellow-700">{{ $pendingProduct->count() }}</p>
                </div>
            </div>

            {{-- Grafik Stok Barang --}}
            <div class="bg-white p-4 rounded-xl shadow w-full">
                <h2 class="text-lg font-semibold mb-2">Grafik Stok Barang</h2>
                <div class="h-64 w-full">
                    {{-- Placeholder grafik pakai chart.js atau larapex --}}
                    <canvas id="stokChart"></canvas>
                </div>
            </div>

            {{-- Barang Stok Menipis --}}
            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-2">Stok Menipis</h2>
                <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Produk</th>
                            <th class="px-4 py-2 text-left">Stok</th>
                            <th class="px-4 py-2 text-left">Minimum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dangerStock as $p)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $p->name }}</td>
                                <td class="px-4 py-2">{{ $p->current_stock }}</td>
                                <td class="px-4 py-2">{{ $p->minimum_stock }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-2">Tidak ada stok menipis</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Transaksi Pending --}}
            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-2">Transaksi Pending</h2>
                <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Produk</th>
                            <th class="px-4 py-2">Qty</th>
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingProduct as $tr)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $tr->id }}</td>
                                <td class="px-4 py-2">{{ $tr->product->name }}</td>
                                <td class="px-4 py-2">{{ $tr->quantity }}</td>
                                <td class="px-4 py-2">{{ $tr->user->name }}</td>
                                <td class="px-4 py-2">{{ $tr->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-2">Tidak ada transaksi pending</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Script Chart.js untuk grafik stok --}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('stokChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($productLabels) !!},
                        datasets: [{
                            label: 'Stok Barang',
                            data: {!! json_encode($productStock) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>


    @endif

    @if (Auth::user()->role === 'staff')
        <div class="p-6 space-y-6">

            {{-- Ringkasan Angka --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="p-4 bg-blue-100 rounded-xl shadow text-center border-l-4 border-blue-400">
                    <h2 class="text-lg font-semibold">Barang Masuk Hari Ini</h2>
                    <p class="text-2xl font-bold text-blue-700">{{ $barangMasuk->count() }}</p>
                </div>
                <div class="p-4 bg-green-100 rounded-xl shadow text-center border-l-4 border-green-400">
                    <h2 class="text-lg font-semibold">Barang Keluar Hari Ini</h2>
                    <p class="text-2xl font-bold text-green-700">{{ $barangKeluar->count() }}</p>
                </div>
                <div class="p-4 bg-yellow-100 rounded-xl shadow text-center border-l-4 border-yellow-400">
                    <h2 class="text-lg font-semibold">Stok Menipis</h2>
                    <p class="text-2xl font-bold text-yellow-700">{{ $dangerStock->count() }}</p>
                </div>
                <div class="p-4 bg-red-100 rounded-xl shadow text-center border-l-4 border-red-400">
                    <h2 class="text-lg font-semibold">Pending Approval</h2>
                    <p class="text-2xl font-bold text-red-700">{{ $pending->count() }}</p>
                </div>
            </div>

            {{-- Barang Masuk Hari Ini --}}
            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-2">Barang Masuk Hari Ini</h2>
                <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Produk</th>
                            <th class="px-4 py-2 text-left">Qty</th>
                            <th class="px-4 py-2 text-left">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangMasuk as $bm)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $bm->product->name }}</td>
                                <td class="px-4 py-2">{{ $bm->quantity }}</td>
                                <td class="px-4 py-2">{{ $bm->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-2">Tidak ada barang masuk hari ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Barang Keluar Hari Ini --}}
            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-2">Barang Keluar Hari Ini</h2>
                <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Produk</th>
                            <th class="px-4 py-2 text-left">Qty</th>
                            <th class="px-4 py-2 text-left">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangKeluar as $bk)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $bk->product->name }}</td>
                                <td class="px-4 py-2">{{ $bk->quantity }}</td>
                                <td class="px-4 py-2">{{ $bk->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-2">Tidak ada barang keluar hari ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Stok Menipis --}}
            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-2">Stok Menipis</h2>
                <ul class="list-disc pl-6">
                    @forelse($dangerStock as $p)
                        <li>{{ $p->name }} (stok: {{ $p->current_stock }})</li>
                    @empty
                        <li>Tidak ada stok menipis</li>
                    @endforelse
                </ul>
            </div>

            {{-- Pending Approval --}}
            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-2">Pending Approval</h2>
                <ul class="list-disc pl-6">
                    @forelse($pending as $tr)
                        <li>Transaksi ID {{ $tr->id }} - {{ $tr->product->name }} ({{ $tr->quantity }})
                        </li>
                    @empty
                        <li>Tidak ada transaksi pending</li>
                    @endforelse
                </ul>
            </div>
        </div>

    @endif
</x-layout>
