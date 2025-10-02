<x-layout>
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg mt-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Product Attribute</h1>

        <form action="{{ route('productAttribute.update', $productAttribute->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Pilih Produk --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                <select name="product_id"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 border p-3">
                    <option value="">-- Pilih Product --</option>
                    @foreach ($products as $pr)
                        <option value="{{ $pr->id }}"
                            {{ old('product_id', $productAttribute->product_id) == $pr->id ? 'selected' : '' }}>
                            {{ $pr->name }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Quantity --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $productAttribute->name) }}"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 border p-3">
                @error('quantity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <input type="text" name="value" value="{{ old('description', $productAttribute->value) }}"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 border p-3">
                @error('value')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-between items-center">
                <a href="{{ route('productAttribute.index') }}" class="text-gray-600 hover:text-gray-800 transition">←
                    Back</a>

                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-layout>
