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
            colors: {
                // Lazy Days Pastel Color Palette - Enhanced & Vibrant
                'bloom': {
                    'teal': '#6B9A94',      // Darker teal - primary
                    'teal-light': '#97B3AE', // Light teal - accent
                    'mint': '#8FCB9E',       // More vibrant mint
                    'mint-light': '#C8E6D7', // Light mint
                    'cream': '#F5DDD0',      // Warmer cream
                    'coral': '#E89B94',      // More saturated coral
                    'taupe': '#9D8B7E',      // Darker taupe
                    'ivory': '#FAF8F5',      // Slightly warmer ivory
                },
            },
        },
    },

    plugins: [forms],
};
