import tinymce from 'tinymce/tinymce';

window.tinymce = tinymce;

import 'tinymce/themes/silver';

import 'tinymce/icons/default';

import 'tinymce/skins/ui/oxide/skin.css';
import 'tinymce/skins/content/default/content.css';

import 'tinymce/plugins/advlist';
import 'tinymce/plugins/autolink';
import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/table';
import 'tinymce/plugins/code';
import 'tinymce/plugins/image';
import 'tinymce/plugins/media';
import 'tinymce/plugins/wordcount';
import 'tinymce/plugins/charmap';
import 'tinymce/plugins/preview';
import 'tinymce/plugins/searchreplace';
import 'tinymce/plugins/visualblocks';
import 'tinymce/plugins/fullscreen';
import 'tinymce/plugins/insertdatetime';

window.initTinyMCE = function (selector = '.tinymce') {
    if (!window.tinymce) return;

    tinymce.remove(selector);

    tinymce.init({
        selector: selector,
        height: 450,
        menubar: 'file edit view insert format tools table help',

        base_url: '/tinymce',
        script_url: '/tinymce/tinymce.min.js',
        suffix: '.min',

        plugins:
            'advlist autolink lists link image media table code ' +
            'searchreplace visualblocks fullscreen preview ' +
            'insertdatetime charmap wordcount help',

        toolbar:
            'undo redo | blocks fontfamily fontsize | ' +
            'bold italic underline strikethrough | ' +
            'forecolor backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | ' +
            'link image media table | ' +
            'searchreplace visualblocks code fullscreen preview | help',

        font_family_formats:
            'Figtree=Figtree, sans-serif;' +
            'Arial=arial,helvetica,sans-serif;' +
            'Times New Roman=times new roman,times,serif;' +
            'Courier New=courier new,courier,monospace',

        font_size_formats:
            '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt',

        branding: false,
        promotion: false,

        content_style: `
            body {
                font-family: Figtree, sans-serif;
                font-size: 14px;
            }
        `,

        setup: (editor) => {
            editor.on('change keyup', () => {
                editor.save();
            });
        }
    });
};