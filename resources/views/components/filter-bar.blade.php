<form method="GET" class="mb-4">
    <div class="flex flex-col gap-3 md:flex-row md:items-end">

        @if($search ?? true)
        <div class="flex-1">
            <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">
                {{ $searchLabel ?? 'Cari' }}
            </label>
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="{{ $searchPlaceholder ?? 'Ketik kata kunci…' }}"
                class="w-full px-3 py-2 text-sm rounded-lg border"
            >
        </div>
        @endif

        @if(!empty($categories))
        <div class="w-full md:w-48">
            <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">
                Kategori
            </label>
            <select name="category" class="w-full px-3 py-2 text-sm rounded-lg border">
                <option value="">Semua</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        @selected(request('category') == $cat->id)>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        @if($status ?? true)
        <div class="w-full md:w-40">
            <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">
                Status
            </label>
            <select name="status" class="w-full px-3 py-2 text-sm rounded-lg border">
                <option value="">Semua</option>
                <option value="draft" @selected(request('status')==='draft')>Draft</option>
                <option value="published" @selected(request('status')==='published')>Published</option>
            </select>
        </div>
        @endif

        <div class="flex gap-2">
            <button class="px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg
                hover:bg-emerald-700 transition">
                Filter
            </button>
            <a href="{{ url()->current() }}"
               class="px-4 py-2 bg-gray-200 rounded-lg text-sm font-semibold rounded-lg
               hover:bg-gray-300">
                Reset
            </a>
        </div>
    </div>
</form>
