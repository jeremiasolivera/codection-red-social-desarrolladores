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
                base: ['0.60rem', '0.70rem'], // Base a 14px con altura de línea ajustada
                xs: ['0.60rem', '.70rem'],       // Texto pequeño de 12px
                sm: ['0.75rem', '.9rem'],       // Texto pequeño de 12px
                md: ['0.80rem', '1.1rem'],       // Texto pequeño de 12px
                lg: ['1rem', '1.5rem'],         // Texto grande de 16px
                xl: ['1.125rem', '1.75rem'],    // Texto extra grande de 18px
            },
            screens: {
                'max-xs': { 'max': '479px' }, // hasta 479px
                'max-sm': { 'max': '700px' }, // hasta 479px
                'max-md': { 'max': '900px' }, // hasta 479px
                'max-l': { 'max': '1600px' },
              },
        },
    },

    plugins: [forms],
};
