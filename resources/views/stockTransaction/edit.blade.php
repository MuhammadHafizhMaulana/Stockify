<x-layout>
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg mt-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Stock Transaction</h1>

        <form action="{{ route('stockTransaction.update', $stockTransaction->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Pilih Produk --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                <select name="product_id"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value="">-- Pilih Product --</option>
                    @foreach ($product as $pr)
                        <option value="{{ $pr->id }}"
                            {{ old('product_id', $stockTransaction->product_id) == $pr->id ? 'selected' : '' }}>
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                <input type="number" name="quantity" value="{{ old('quantity', $stockTransaction->quantity) }}"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                @error('quantity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Type --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value="">-- Pilih Type --</option>
                    <option value="masuk" {{ old('type', $stockTransaction->type) == 'masuk' ? 'selected' : '' }}>
                        Masuk</option>
                    <option value="keluar" {{ old('type', $stockTransaction->type) == 'keluar' ? 'selected' : '' }}>
                        Keluar</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value="">-- Pilih Status --</option>
                    <option value="pending"
                        {{ old('status', $stockTransaction->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="diterima"
                        {{ old('status', $stockTransaction->status) == 'diterima' ? 'selected' : '' }}>Diterima
                    </option>
                    <option value="ditolak"
                        {{ old('status', $stockTransaction->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="dikeluarkan"
                        {{ old('status', $stockTransaction->status) == 'dikeluarkan' ? 'selected' : '' }}>Dikeluarkan
                    </option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <input type="text" name="notes" value="{{ old('notes', $stockTransaction->notes) }}"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                @error('notes')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-between items-center">
                <a href="{{ route('stockTransaction.index') }}" class="text-gray-600 hover:text-gray-800 transition">←
                    Back</a>

                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-layout>
