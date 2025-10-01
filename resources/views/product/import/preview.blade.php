<x-layout>
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Preview Data Produk</h2>

        <table class="w-full border border-gray-300 mb-4 text-sm">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2">#</th>
                    <th class="border p-2">Nama</th>
                    <th class="border p-2">SKU</th>
                    <th class="border p-2">Supplier</th>
                    <th class="border p-2">Kategori</th>
                    <th class="border p-2">Harga Beli</th>
                    <th class="border p-2">Harga Jual</th>
                    <th class="border p-2">Min. Stok</th>
                    <th class="border p-2">Stok Saat Ini</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $index => $row)
                    <tr>
                        <td class="border p-2">{{ $index + 1 }}</td>
                        <td class="border p-2">{{ $row['name'] }}</td>
                        <td class="border p-2">{{ $row['sku'] }}</td>
                        <td class="border p-2">{{ $row['supplier_id'] }}</td>
                        <td class="border p-2">{{ $row['category_id'] }}</td>
                        <td class="border p-2">{{ $row['purchase_price'] }}</td>
                        <td class="border p-2">{{ $row['selling_price'] }}</td>
                        <td class="border p-2">{{ $row['minimum_stock'] }}</td>
                        <td class="border p-2">{{ $row['current_stock'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('product.import.store') }}" method="POST">
            @csrf
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                Konfirmasi & Import ke Database
            </button>
            <a href="{{ route('product.import.form') }}" class="ml-3 text-red-600">Batal</a>
        </form>
    </div>
</x-layout>
