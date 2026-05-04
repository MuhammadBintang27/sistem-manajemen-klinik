import defaultTheme from 'tailwindcss/defaultTheme';
const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
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
            colors: {
                primary: {
                    DEFAULT: '#D94A8C',
                    '50': '#F8D6E3',
                    '100': '#F0B5CE',
                    '200': '#E899B8',
                    '300': '#F3A6C6',
                    '400': '#E77BAA',
                    '500': '#D94A8C',
                    '600': '#C63F7F',
                    '700': '#B93876',
                    '800': '#A8316D',
                    '900': '#972664',
                },
                secondary: {
                    DEFAULT: '#F8D6E3',
                    '50': '#FEF8FB',
                    '100': '#F8D6E3',
                    '200': '#F0B5CE',
                    '300': '#E8A0C5',
                    '400': '#D85595',
                },
                accent: {
                    DEFAULT: '#D4AF37',
                    'gold': '#D4AF37',
                    'soft': '#E6C768',
                },
            },
            boxShadow: {
                'sm': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
                'md': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                'lg': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};

