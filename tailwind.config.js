import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    // Tanpa dark theme, varian `dark:` harus mengikuti class `.dark` pada <html>
    // dan bukan `prefers-color-scheme`. Kalau dibiarkan 'media' (default Tailwind 3),
    // semua varian `dark:` ikut aktif saat OS/browser user dalam mode gelap —
    // termasuk view pagination bawaan Laravel (`dark:bg-gray-800`).
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
