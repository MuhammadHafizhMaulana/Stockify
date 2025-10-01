<x-layout>
    <section class="py-10 bg-gray-50 dark:bg-gray-900 antialiased">
        <div class="max-w-screen-xl mx-auto px-4 md:px-8">
            <!-- Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="grid lg:grid-cols-2">

                    <!-- Gambar Produk -->
                    <div class="p-6 md:p-8 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                        <img class="rounded-xl shadow-md hover:scale-105 transition-transform duration-300"
                            src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/600x400.png' }}"
                            alt="Image of {{ $product->name }}" />
                    </div>

                    <!-- Detail Produk -->
                    <div class="p-6 md:p-10 flex flex-col justify-between">
                        <div>
                            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4">
                                {{ ucwords($product->name) }}
                            </h1>
                            <div class="space-y-3 text-gray-700 dark:text-gray-200">
                                <p><span class="font-semibold">SKU:</span> {{ $product->sku }}</p>
                                <p><span class="font-semibold">Purchase Price:</span> Rp
                                    {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
                                <p><span class="font-semibold">Selling Price:</span> Rp
                                    {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                                <p><span class="font-semibold">Minimum Stock:</span> {{ $product->minimum_stock }}</p>
                                <p><span class="font-semibold">Current Stock:</span> {{ $product->current_stock }}</p>
                            </div>

                            <hr class="my-6 border-gray-300 dark:border-gray-600">

                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                {{ ucfirst($product->description) }}
                            </p>
                        </div>

                        <!-- Tombol -->
                        <div class="mt-8">
                            <a href="{{ route('product.edit', $product->id) }}"
                                class="inline-flex items-center px-6 py-3 text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-800 rounded-lg font-medium transition duration-200 shadow-md hover:shadow-lg">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>

                                Edit Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
