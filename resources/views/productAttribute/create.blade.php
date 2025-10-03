<x-layout>
    <div class="bg-white dark:bg-gray-700 rounded-lg p-3">

        <h2 class="text-lg font-bold mb-4">Tambah Attribute untuk {{ $product->name }}</h2>

        <form action="{{ route('productAttribute.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name Attribute</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 py-1 pl-1 w-full border rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="value" class="block text-sm font-medium text-gray-700">Value</label>
                <textarea name="value" id="value" required class="mt-1 py-1 pl-1 w-full border rounded border-gray-300"></textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('product.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded">Batal</a>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</x-layout>
