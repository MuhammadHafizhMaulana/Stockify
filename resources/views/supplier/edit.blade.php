
<x-layout>
    <div
        class="h-fit bg-white border border-gray-200 shadow-2xs rounded-xl p-4 md:p-5 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
        <h1 class="py-3">Edit Supplier</h1>


        <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="max-w-sm space-y-3 pb-3">
                <div class="relative">
                    <input type="text"
                        class="peer py-2.5 sm:py-3 ps-3 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Enter name" name="name" value="{{ $supplier->name }}">
                </div>

                <div class="relative">
                    <input type="text"
                        class="peer py-2.5 sm:py-3 ps-3 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Enter address" name="address" value="{{ $supplier->address }}">
                </div>

                <div class="relative">
                    <input type="text"
                        class="peer py-2.5 sm:py-3 ps-3 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Enter phone number" name="phone" value="{{ $supplier->phone }}">
                </div>

                <div class="relative">
                    <input type="email"
                        class="peer py-2.5 sm:py-3 ps-3 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Enter email" name="email" value="{{ $supplier->email }}">
                </div>
            </div>

            <button type="submit" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-950 text-white hover:bg-gray-600 focus:outline-hidden focus:bg-gray-600 disabled:opacity-50 disabled:pointer-events-none" >Update</button>
        </form></br>
        <a href="{{ route('supplier.index') }}" class="hover:underline">&laquo; Back to List</a>
    </div>
</x-layout>
