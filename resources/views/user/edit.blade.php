<x-layout>
    <div class="mt-10 x-data:mt-0 flex items-center justify-center bg-transparent bg-blend-screen dark:bg-transparent"
        x-data="{ editing: false }">
        {{-- state Alpine --}}

        <div
            class="w-full max-w-md bg-white border border-gray-200 shadow rounded-xl p-6
                    dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">

            {{-- Header + tombol Edit / Cancel --}}
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Profile {{ ucfirst($user->role) }}
                </h2>
                <button type="button" @click="editing = !editing"
                    class="px-3 py-1.5 text-sm font-medium rounded-md border border-transparent
                               bg-blue-600 text-white hover:bg-blue-700 focus:outline-none"
                    x-text="editing ? 'Cancel' : 'Edit'">
                </button>
            </div>

            {{-- Form --}}
            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Foto --}}
                <div class="flex justify-center">
                    <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://placehold.co/600x400.png' }}"
                        alt="Profile Image"
                        class="w-32 h-32 object-cover rounded-full border-4 border-white shadow-md hover:scale-105 transition-transform duration-300" />


                </div>

                {{-- Profile --}}
                <div x-show="editing" x-transition>
                    <label class="block mb-1 text-sm font-medium">Foto Profile</label>
                    <input type="file" name="image"
                        class="w-full px-3 py-2 rounded-lg bg-gray-100 border-transparent
               focus:border-blue-500 focus:ring-blue-500
               disabled:opacity-50 disabled:pointer-events-none
               dark:bg-neutral-700 dark:text-neutral-300">
                </div>

                {{-- Name --}}
                <div>
                    <label class="block mb-1 text-sm font-medium">Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" :disabled="!editing"
                        class="w-full px-3 py-2 rounded-lg bg-gray-100 border-transparent
                                  focus:border-blue-500 focus:ring-blue-500
                                  disabled:opacity-50 disabled:pointer-events-none
                                  dark:bg-neutral-700 dark:text-neutral-300">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block mb-1 text-sm font-medium">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" :disabled="!editing"
                        class="w-full px-3 py-2 rounded-lg bg-gray-100 border-transparent
                                  focus:border-blue-500 focus:ring-blue-500
                                  disabled:opacity-50 disabled:pointer-events-none
                                  dark:bg-neutral-700 dark:text-neutral-300">
                </div>

                {{-- Tampilan Admin --}}
                @if (Auth::user()->role === 'admin')
                    {{-- Role --}}
                    @if (Auth::user()->id != $user->id)
                        <div>
                            <label class="block mb-1 text-sm font-medium">Role</label>
                            <select name="role" :disabled="!editing"
                                class="w-full px-3 py-2 rounded-lg bg-gray-100 border-gray-200
                                   focus:border-blue-500 focus:ring-blue-500
                                   disabled:opacity-50 disabled:pointer-events-none
                                   dark:bg-neutral-700 dark:text-neutral-300">
                                <option value="">-- Pilih Type --</option>
                                <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff
                                    Gudang</option>
                                <option value="manajer" {{ old('role', $user->role) == 'manajer' ? 'selected' : '' }}>
                                    Manajer
                                    Gudang</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                                    Gudang</option>
                            </select>
                        </div>
                    @endif
                @endif

                {{-- Password hidden agar tidak berubah --}}
                <input type="hidden" name="password" value="{{ $user->password }}">

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
