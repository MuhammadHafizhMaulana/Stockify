<x-layout>

    <style>
        /* Agar elemen dengan x-cloak selalu tersembunyi sebelum Alpine aktif */
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="w-full pb-2" x-data="{ open: false }">
        <div class="w-full flex justify-between mb-4">
            <div class="w-full ">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-white uppercase bg-blue-950 dark:bg-gray-700 dark:text-gray-400 rou">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs">
                                Total Product : {{ $products->count() }}
                                <a href="{{ route('product.index') }}"
                                    class="inline-flex items-center mb-4 ml-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow text-xs">
                                    View Product
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total Supplier : {{ $suppliers->count() }}
                                <a href="{{ route('supplier.index') }}"
                                    class="inline-flex items-center mb-4 ml-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow text-xs">
                                    View Product
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total Category : {{ $categories->count() }}
                                {{-- Tombol toggle --}}
                                <button @click="open = !open"
                                    class="text-xs mb-4 ml-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow">
                                    + Category
                                </button>
                            </th>

                        </tr>
                    </thead>
                </table>
            </div>
        </div>


        {{-- Form Tambah --}}
        <div x-show="open" x-cloak x-transition class="border p-6 rounded-lg bg-gray-50 shadow">
            <h2 class="text-lg font-bold mb-4">Form Tambah Category</h2>

            <form action="{{ route('category.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 py-1 pl-1 w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="description" class="w-full block text-sm font-medium text-gray-700">Description</label>
                    <textarea type="text" name="description" id="description" required
                        class="w-full rounded border-gray-300 data-hs-textarea-auto-height"></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" @click="open = false"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-white uppercase bg-blue-950 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Category Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Add at
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ ucwords($category->name) }}
                        </th>
                        <td class="px-6 py-4">
                            {{ ucfirst($category->description) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $category->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            {{-- Link ke halaman edit --}}
                            <a href="{{ route('category.edit', $category->id) }}" class="button"> <button type="button"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</button></a>

                            {{-- Form delete --}}
                            <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                class="inline button" onsubmit="return confirm('Yakin hapus category ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</x-layout>
