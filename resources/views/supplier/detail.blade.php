<x-layout>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="w-full mb-4" x-data="{ open: false }">

        <div class="w-full">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-white bg-blue-950 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <p>
                                SUPPLIER : {{ ucwords($supplier->name) }} <br>
                                EMAIL : {{ $supplier->email }} <br>
                                PHONE : {{ $supplier->phone }} <br>
                            </p>
                            {{-- Total Product: {{ $products->count() }}
                            <a href="{{ route('product.index') }}"
                                class="inline-flex items-center mb-4 ml-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow text-xs">
                                View All Product
                            </a> --}}
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @if ($products->count())
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-white uppercase bg-blue-950 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Product</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">SKU</th>
                        <th class="px-6 py-3">Current Stock</th>
                        <th class="px-6 py-3">Added At</th>
                        <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ ucwords($product->name) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $product->sku }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $product->current_stock }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $product->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td class="px-6 py-4 flex space-x-2">
                                {{-- Edit product --}}
                                <a href="{{ route('product.edit', $product->id) }}">
                                    <button type="button"
                                        class="text-white text-xs bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Edit
                                    </button>
                                </a>

                                {{-- Form delete --}}
                                @if ($product->current_stock <= 0)
                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus product ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-white text-xs bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="mt-4">Belum ada produk untuk supplier ini.</p>
    @endif

</x-layout>
