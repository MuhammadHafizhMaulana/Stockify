<x-layout>
    Filter Periode
    <form method="GET" class="mb-6 flex gap-2">
        <input type="date" name="start_date" value="{{ request('start_date', $data['periode'][0]) }}"
            class="border rounded p-2">
        <input type="date" name="end_date" value="{{ request('end_date', $data['periode'][1]) }}"
            class="border rounded p-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Terapkan</button>
    </form>
    <h1 class="text-xl font-bold mb-4">
        Log Activity untuk User: {{ $user->name }} / {{ $user->role }}
    </h1>
    {{-- Tombol Export --}}
    <div class="mb-4 flex gap-3">
        <a href="{{ route('report.user.pdf', ['user' => $user->id] + request()->query()) }}"
            class="bg-red-500 text-white px-4 py-2 rounded">Export PDF</a>
    </div>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-3 py-2">No</th>
                <th class="border px-3 py-2">Action</th>
                <th class="border px-3 py-2">Description</th>
                <th class="border px-3 py-2">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @if (!$data['details']){
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                        Belum ada log aktivitas.
                    </td>
                </tr>
                }
            @else
                @foreach ($data['details'] as $index => $log)
                    <tr>
                        <td class="border px-3 py-2">{{ $data['details']->firstItem() + $index }}</td>
                        <td class="border px-3 py-2">{{ $log->action }}</td>
                        <td class="border px-3 py-2">{{ $log->description }}</td>
                        <td class="border px-3 py-2">{{ $log->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach

            @endif

        </tbody>
    </table>

    <div class="mt-4">
        {{ $data['details']->links() }}
    </div>
    {{-- Tombol Kembali --}}
    <div class="mt-6">
        <a href="{{ route('report.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            ← Kembali ke Halaman Report
        </a>
    </div>

</x-layout>
