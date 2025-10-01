<x-layout>
    <div
        class="max-w-lg mx-auto odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-white dark:text-white border-gray-200 p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Import Produk dari Excel</h2>

        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('product.import.preview') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label class="block mb-2 font-medium">Pilih File Excel</label>
            <input type="file" name="file" class="border rounded w-full p-2 mb-4" required>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Preview Data
            </button>
        </form>
    </div>
</x-layout>
