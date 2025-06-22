import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
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
module.exports = {
    darkMode: 'class', // или 'media', но 'class' — более гибкий
    content: ['./resources/**/*.blade.php', './resources/**/*.vue', './resources/**/*.js'],
    theme: {
        extend: {},
    },
    plugins: [],
};
