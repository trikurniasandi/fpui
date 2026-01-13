<div x-data="confirmDeleteModal()" class="inline-block">
    <!-- Trigger -->
    <button
        type="button"
        @click="open('{{ $action }}')"
        {{ $attributes->merge([
            'class' => 'inline-flex items-center px-3 py-1.5
                        bg-red-600 text-white rounded-md
                        text-xs font-semibold
                        hover:bg-red-700 transition'
        ]) }}
    >
        {{ $slot }}
    </button>

    <!-- Modal (TIDAK dirender saat awal load) -->
    <template x-if="show">
        <div
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center"
        >
            <!-- Backdrop -->
            <div
                class="absolute inset-0 bg-black/50"
                @click="close()"
            ></div>

            <!-- Modal -->
            <div
                x-transition
                class="relative bg-white dark:bg-gray-800
                       w-full max-w-md mx-4
                       rounded-xl shadow-lg p-6
                       text-left"
            >
                <div class="space-y-2">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        {{ $title ?? 'Konfirmasi Hapus' }}
                    </h3>

                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        {{ $message ?? 'Apakah kamu yakin ingin menghapus data ini?' }}
                    </p>
                </div>

                <div class="mt-6 flex flex-col-reverse sm:flex-row gap-3 sm:justify-end">
                    <button
                        type="button"
                        @click="close()"
                        class="px-4 py-2 rounded-lg
                               border border-gray-300 dark:border-gray-600
                               text-gray-700 dark:text-gray-200
                               hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                    >
                        Batal
                    </button>

                    <form :action="action" method="POST">
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="px-4 py-2 rounded-lg
                                   bg-red-600 text-white font-semibold
                                   hover:bg-red-700 transition"
                        >
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    function confirmDeleteModal() {
        return {
            show: false,
            action: '',

            open(url) {
                this.action = url
                this.show = true
            },

            close() {
                this.show = false
                this.action = ''
            }
        }
    }
</script>