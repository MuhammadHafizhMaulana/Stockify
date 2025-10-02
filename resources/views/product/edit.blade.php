<x-layout>
    <div
        class="h-fit bg-white border border-gray-200 shadow-2xs rounded-xl p-4 md:p-5 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
        <h1 class="py-3">Edit Supplier</h1>


        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="max-w-sm space-y-3 pb-3">
                <div class="relative">
                    <input type="text"
                        class="peer py-2.5 sm:py-3 ps-3 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Enter name" name="name" value="{{ $product->name }}">
                </div>

                <div class="relative pb-3">
                    <select name="supplier_id">
                        @foreach ($supplier as $sup)
                            <option value="{{ $sup->id }}"
                                {{ old('supplier_id', $product->sup_id) == $sup->id ? 'selected' : '' }}>
                                {{ $sup->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="relative pb-3">
                    <select name="category_id">
                        @foreach ($category as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $product->cat_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="relative">
                    <input type="text"
                        class="peer py-2.5 sm:py-3 ps-3 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Enter SKU" name="sku" value="{{ $product->sku }}">
                </div>

                <div class="relative">
                    <input type="text"
                        class="peer py-2.5 sm:py-3 ps-3 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Enter description" name="description" value="{{ $product->description }}">
                </div>

                <div class="relative">
                    <input type="number"
                        class="peer py-2.5 sm:py-3 ps-3 block w-full bg-gray-100 border-transparent rounded-lg sm:number-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:number-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Enter purchase price" name="purchase_price" max="9999999999"
                        value="{{ $product->purchase_price }}">
                </div>

                <div class="relative">
                    <input type="number"
                        class="peer py-2.5 sm:py-3 ps-3 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Enter selling price" name="selling_price" max="9999999999"
                        value="{{ $product->selling_price }}">
                </div>

                <div class="relative">
                    <label>Image</label><br>
                    <input type="file" name="image"
                        class="py-1 pl-1 m-1 w-full border-1 rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="" width="100">
                    @endif
                    @error('image')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="relative">
                    <input type="number"
                        class="peer py-2.5 sm:py-3 ps-3 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Enter stock" name="minimum_stock" max="9999999999"
                        value="{{ $product->minimum_stock }}">
                </div>
            </div>

            <button type="submit"
                class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-950 text-white hover:bg-gray-600 focus:outline-hidden focus:bg-gray-600 disabled:opacity-50 disabled:pointer-events-none">Update</button>
        </form></br>
        <a href="{{ route('product.index') }}" class="hover:underline">&laquo; Back to List</a>
    </div>
</x-layout>
