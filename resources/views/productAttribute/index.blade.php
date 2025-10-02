<x-layout>

    <style>
        /* Agar elemen dengan x-cloak selalu tersembunyi sebelum Alpine aktif */
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="w-full pb-2" x-data="{ open: false }">

        <div class="mb-4">
            {{-- Tombol toggle --}}
            <button @click="open = !open"
                class="mb-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow">
                + Tambah Attribute
            </button>
        </div>


        {{-- Form Tambah --}}
        <div x-show="open" x-cloak x-transition class="border p-6 rounded-lg bg-gray-50 shadow">
            <h2 class="text-lg font-bold mb-4">Form Request</h2>

            <form action="{{ route('productAttribute.store') }}" method="POST" class="space-y-4"> @csrf
                <div>
                    <label for="product" class="block text-sm font-medium text-gray-700">Product</label>
                    <select name="product_id" id="product" required>
                        <option value="">-- Pilih Product --</option>
                        @foreach ($product as $pr)
                            <option value="{{ $pr->id }}" {{ old('product_id') == $pr->id ? 'selected' : '' }}>
                                {{ ucwords($pr->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name Attribute</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 py-1 pl-1 w-full border-1 rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="value" class="w-full block text-sm font-medium text-gray-700">Value</label>
                    <textarea type="text" name="value" id="value" required
                        class=" mt-1 py-1 pl-1 w-full border-1 rounded border-gray-300 data-hs-textarea-auto-height"></textarea>
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

    @if ($productAttributes->count())
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-white uppercase bg-blue-950 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Product Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Value
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productAttributes as $productAttribute)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $productAttribute->product->name }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $productAttribute->name }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $productAttribute->value }}
                            </th>
                            <th>
                                {{-- Link ke halaman edit --}}
                                <a href="{{ route('productAttribute.edit', $productAttribute->id) }}"
                                    class="button text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</a>

                                {{-- Form delete --}}
                                <form action="{{ route('productAttribute.destroy', $productAttribute->id) }}"
                                    method="POST" class="inline button"
                                    onsubmit="return confirm('Yakin hapus transaction ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Hapus</button>
                                </form>
                            </th>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Belum ada data produk attribut.</p>
    @endif


</x-layout>
