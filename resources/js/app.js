import './bootstrap';
import './tinymce';

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

window.Alpine = Alpine;

Alpine.plugin(intersect);

Alpine.start();