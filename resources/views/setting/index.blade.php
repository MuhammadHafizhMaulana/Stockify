<x-layout>
    <div class="mt-10 x-data:mt-0 flex items-center justify-center bg-transparent bg-blend-screen dark:bg-transparent"
        x-data="{ editing: false }">
        {{-- state Alpine --}}

        <div
            class="w-full max-w-md bg-white border border-gray-200 shadow rounded-xl p-6
                    dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">

            {{-- Header + tombol Edit / Cancel --}}
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Setting Application</h2>
                <button type="button" @click="editing = !editing"
                    class="px-3 py-1.5 text-sm font-medium rounded-md border border-transparent
                               bg-blue-600 text-white hover:bg-blue-700 focus:outline-none"
                    x-text="editing ? 'Cancel' : 'Edit'">
                </button>
            </div>

            {{-- Form --}}
            <form action="{{ isset($setting) ? route('setting.update', $setting->id) : route('setting.store') }}"
                method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @if (isset($setting))
                    @method('PUT')
                @endif

                {{-- Foto --}}
                <div class="flex justify-center">
                    <img src="{{ $setting && $setting->logo ? asset('storage/' . $setting->logo) : 'https://placehold.co/600x400.png' }}"
                        alt="Logo"
                        class="w-32 h-32 object-cover rounded-lg border-4 border-white shadow-md hover:scale-105 transition-transform duration-300" />


                </div>

                {{-- Profile --}}
                <div x-show="editing" x-transition>
                    <label class="block mb-1 text-sm font-medium">Logo</label>
                    <input type="file" name="logo"
                        class="w-full px-3 py-2 rounded-lg bg-gray-100 border-transparent
               focus:border-blue-500 focus:ring-blue-500
               disabled:opacity-50 disabled:pointer-events-none
               dark:bg-neutral-700 dark:text-neutral-300">
                </div>

                {{-- Name --}}
                <div>
                    <label class="block mb-1 text-sm font-medium">Title</label>
                    <input type="text" name="title" value="{{ ucwords($setting->title) ?? 'default' }}"
                        :disabled="!editing"
                        class="w-full px-3 py-2 rounded-lg bg-gray-100 border-transparent
                                  focus:border-blue-500 focus:ring-blue-500
                                  disabled:opacity-50 disabled:pointer-events-none
                                  dark:bg-neutral-700 dark:text-neutral-300">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block mb-1 text-sm font-medium">Slogan</label>
                    <input type="text" name="slogan" value="{{ ucfirst($setting->slogan) ?? 'default' }}"
                        :disabled="!editing"
                        class="w-full px-3 py-2 rounded-lg bg-gray-100 border-transparent
                                  focus:border-blue-500 focus:ring-blue-500
                                  disabled:opacity-50 disabled:pointer-events-none
                                  dark:bg-neutral-700 dark:text-neutral-300">
                </div>

                {{-- Tombol Update hanya muncul saat editing --}}
                <div class="pt-4" x-show="editing" x-transition>
                    <button type="submit"
                        class="w-full py-2 px-4 text-sm font-medium rounded-lg border border-transparent
                                   bg-blue-700 text-white hover:bg-blue-800 focus:outline-none">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
