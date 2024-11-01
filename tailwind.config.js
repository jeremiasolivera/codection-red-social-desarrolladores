import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                sans: ['Poppins', 'sans-serif'],
            },
            fontSize: {
                base: ['0.875rem', '1.25rem'], // Base a 14px con altura de línea ajustada
                sm: ['0.75rem', '1rem'],       // Texto pequeño de 12px
                lg: ['1rem', '1.5rem'],         // Texto grande de 16px
                xl: ['1.125rem', '1.75rem'],    // Texto extra grande de 18px
            }
        },
    },

    plugins: [forms],
};
