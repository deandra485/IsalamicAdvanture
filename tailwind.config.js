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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // PERBAIKAN: Colors dimasukkan ke dalam extend
            // Agar warna bawaan (seperti white, black, gray) TIDAK HILANG
            colors: {
                primary: {
                    100: '#f0f9ff',
                    200: '#e0f2fe',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                }
            }
        },
    },

    plugins: [forms],
};