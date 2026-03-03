<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Edit Pengguna
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <form action="{{ route('admin.settings.user.update', $user->id) }}" 
                method="POST" 
                enctype="multipart/form-data"
                class="bg-white dark:bg-gray-800 
                       border border-gray-200 dark:border-gray-700 
                       rounded-xl shadow-sm p-6 space-y-10">
                
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                        Informasi Pengguna
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Nama <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                name="name" 
                                value="{{ old('name', $user->name) }}" 
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                       dark:bg-gray-900 dark:text-gray-100"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                name="email" 
                                value="{{ old('email', $user->email) }}" 
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                       dark:bg-gray-900 dark:text-gray-100"
                                required>
                        </div>
                    </div>
                </div>
                    
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Hak pengguna <span class="text-red-500">*</span>
                    </label>
                    <select name="role"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600
                               dark:bg-gray-900 dark:text-gray-100
                               focus:border-emerald-500 focus:ring-emerald-500"
                        required>
                        <option value="admin" 
                            {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>
                        <option value="user" 
                            {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>
                            User
                        </option>
                    </select>
                </div>
               
                <div class="flex justify-end gap-3 pt-6 border-t dark:border-gray-700">
                    <a href="{{ route('admin.settings.user.index') }}"
                        class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">
                        Update Pengguna
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>