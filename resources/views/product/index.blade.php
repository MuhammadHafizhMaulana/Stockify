<x-layout>

    <style>
        /* Agar elemen dengan x-cloak selalu tersembunyi sebelum Alpine aktif */
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="w-full pb-2" x-data="{ open: false }">

        <div class="w-full flex justify-between mb-4 rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-white uppercase bg-blue-950 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Total Product : {{ $products->count() }}
                            {{-- Tombol toggle --}}
                            <button @click="open = !open"
                                class="inline-flex items-center mb-4 ml-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow text-xs">
                                + Product
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total Supplier : {{ $suppliers->count() }}
                            <a href="{{ route('supplier.index') }}"
                                class="inline-flex items-center mb-4 ml-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow text-xs">
                                View All
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total Category : {{ $categories->count() }}
                            <a href="{{ route('category.index') }}"
                                class="inline-flex items-center mb-4 ml-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow text-xs">
                                View All
                            </a>
                        </th>

                    </tr>
                </thead>
            </table>
        </div>

        @if (Auth::user()->role === 'admin')
            {{-- Tombol ke Index Import --}}
            <div class="mt-6 mb-4">
                <a href="{{ route('product.import.form') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 font-semibold rounded shadow">
                    Import Produk
                </a>
        @endif
        <a href="{{ route('productAttribute.index') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 font-semibold rounded shadow ml-3">
            Tambah Attribute
        </a>
    </div>


    {{-- Form Tambah --}}
    <div x-show="open" x-cloak x-transition class="border p-6 rounded-lg bg-gray-50 shadow">
        <h2 class="text-lg font-bold mb-4">Form Tambah Post</h2>

        <form action="{{ route('product.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 py-1 pl-1 border-1 w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>


            <div>
                <label for="supplier" class="block text-sm font-medium text-gray-700">Supplier</label>
                <select name="supplier_id" id="supplier" required
                    class="mt-1 py-1 pl-1 w-full border-1 rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Pilih Supplier --</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ ucwords($supplier->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" id="category" required
                    class="mt-1 py-1 pl-1 w-full border-1 rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Pilih Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ ucwords($category->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                <input type="text" name="sku" id="sku" required
                    class="mt-1 py-1 pl-1 w-full border-1 rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="description" class="w-full block text-sm font-medium text-gray-700">Description</label>
                <textarea type="text" name="description" id="description" required
                    class=" mt-1 py-1 pl-1 w-full border-1 rounded border-gray-300 data-hs-textarea-auto-height"></textarea>
            </div>

            <div>
                <label for="purchase_price" class="block text-sm font-medium text-gray-700">Purchase Price</label>
                <input type="number" name="purchase_price" id="purchase_price" max="9999999999" min="1" required
                    class="py-1 pl-1 mt-1 w-full border-1 rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="selling_price" class="block text-sm font-medium text-gray-700">Selling Price</label>
                <input type="number" name="selling_price" id="selling_price" max="9999999999" min="1" required
                    class="py-1 pl-1 mt-1 w-full border-1 rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" required
                    class="py-1 pl-1 mt-1 w-full border-1 rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700">Minimum Stock</label>
                <input type="number" name="minimum_stock" id="stock" max="9999999999" min="1" required
                    class="py-1 pl-1 mt-1 w-full border-1 rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" @click="open = false" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
    </div>

    @if ($products->count())
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-white uppercase bg-blue-950 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Product Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Supplier
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Minimum Stock
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Current Stock
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Attribute
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ ucfirst($product->name) }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ ucfirst($product->supplier->name) }}
                            </th>
                            <td class="px-6 py-4">
                                {{ ucfirst($product->category->name) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $product->minimum_stock }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $product->current_stock }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @foreach ($product->productAttribute as $pras)
                                    <p>{{ ucfirst($pras->name) . ', ' }}</p>
                                @endforeach
                                <a href="{{ route('productAttribute.create', $product->id) }}"
                                    class="text-xs text-blue-600 ">+</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap"">
                                <div class="flex gap-2">
                                    {{-- Link ke halaman edit --}}
                                    <a href="{{ route('product.edit', $product->id) }}"
                                        class="button text-xs text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full px-5 py-2.5 text-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</a>

                                    {{-- Form delete --}}
                                    @if ($product->current_stock <= 0)
                                        <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Yakin hapus product ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-white text-xs bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full px-5 py-2.5 text-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Hapus</button>
                                        </form>
                                    @endif

                                    {{-- Link ke halaman detail --}}
                                    <a href="{{ route('product.show', $product->id) }}"
                                        class="button text-xs text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full px-5 py-2.5 text-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Detail</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Belum ada data Product.</p>
    @endif


</x-layout>
