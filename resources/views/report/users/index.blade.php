<x-layout>

    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Log Aktivitas Terbaru User</h1>
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
            <a href="{{ route('report.users.pdf', request()->query()) }}"
                class="bg-red-500 text-white px-4 py-2 rounded">Export PDF</a>
        </div>

        {{-- pesan sukses/error jika ada --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Nomer</th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3">Aksi</th>
                        <th class="px-4 py-3">Deskripsi</th>
                        <th class="px-4 py-3">IP / Agent</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data['details'] as $index => $log)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">
                                {{ $data['details']->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $log->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $log->user->name . '/' . $log->user?->role ?? '—' }}
                                <div class="text-xs text-gray-400">{{ $log->user?->email }}</div>
                            </td>
                            <td class="px-4 py-2 font-medium">
                                {{ $log->action }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $log->description }}
                            </td>
                            <td class="px-4 py-2 text-xs text-gray-500">
                                {{ $log->ip_address ?? '-' }}<br>
                                {{ $log->user_agent ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                Belum ada log aktivitas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- pagination --}}
        <div class="mt-4">
            {{ $data['details']->links() }}
        </div>
        {{-- Tombol Kembali --}}
        <div class="mt-6">
            <a href="{{ route('report.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                ← Kembali ke Halaman Report
            </a>
        </div>
    </div>
</x-layout>
