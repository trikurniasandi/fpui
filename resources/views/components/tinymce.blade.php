@props([
    'id' => 'tinymce-' . uniqid(),
    'name' => 'content',
    'value' => '',
])

<div class="tinymce-wrapper">
    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $attributes->merge([
            'class' => 'tinymce w-full rounded-lg border-gray-300 dark:border-gray-600
                        dark:bg-gray-900 dark:text-gray-100'
        ]) }}
    >{{ $value }}</textarea>
</div>

@once
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.initTinyMCE) {
        window.initTinyMCE('.tinymce');
    }
});
</script>
@endpush
@endonce