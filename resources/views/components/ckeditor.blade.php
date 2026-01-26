<div class="ckeditor-wrapper">
    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $attributes->merge([
            'class' => 'w-full rounded-lg border-gray-300 dark:border-gray-600
                        dark:bg-gray-900 dark:text-gray-100'
        ]) }}
    >{{ $value }}</textarea>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<style>
.ck-editor__editable {
    min-height: 300px;
}
.dark .ck-editor__editable {
    background: #111827;
    color: #f9fafb;
}


</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('{{ $id }}');

    if (!el || typeof ClassicEditor === 'undefined') return;

    ClassicEditor.create(el, {
        toolbar: [
            'heading','|',
            'bold','italic','link',
            'bulletedList','numberedList',
            '|','blockQuote',
            'undo','redo'
        ]
    }).then(editor => {
        const form = el.closest('form');
        if (form) {
            form.addEventListener('submit', () => {
                el.value = editor.getData();
            });
        }
    });
});
</script>
