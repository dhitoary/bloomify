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
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
                display: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                // Soft Pastel Elegant Florist Palette
                'bloom': {
                    // Main Colors
                    'primary': '#DDB1B7',           // Powder Pink
                    'primary-light': '#E8C5CC',    // Crystal Rose
                    'primary-lighter': '#F5E5E8',  // Very light pink
                    
                    'secondary': '#E8C5CC',        // Crystal Rose
                    'secondary-light': '#F5E5E8',  // Light crystal rose
                    
                    // Accent / CTA
                    'accent': '#DFA54A',           // Jurassic Gold
                    'accent-dark': '#C99035',      // Hover gold
                    'accent-light': '#E6BE73',     // Buff Yellow
                    
                    // Fuchsia / Vibrant Pink
                    'fuchsia': '#E71E63',          // Vibrant Fuchsia Pink
                    'fuchsia-light': '#F54A92',    // Light Fuchsia
                    'fuchsia-dark': '#C41853',     // Dark Fuchsia
                    
                    // Backgrounds
                    'bg-main': '#F8F3EE',          // Light cream background
                    'bg-cream': '#EADCC8',         // Cream Beige
                    'bg-card': '#FFF9F6',          // Card background
                    'bg-footer': '#DDB1B7',        // Footer dusty pink
                    
                    // Text Colors
                    'text-primary': '#3D312C',     // Dark brown
                    'text-secondary': '#7A6A63',   // Light brown
                    'text-light': '#F8F3EE',       // Light cream text
                    
                    // Borders & Dividers
                    'border': '#E7D6CF',           // Soft border
                    'border-light': '#F0E8E3',     // Very light border
                    
                    // Support Colors (Soft & Muted)
                    'success': '#C4B5A0',          // Muted green
                    'error': '#D4A9a0',            // Muted red
                    'warning': '#E8C589',          // Muted yellow
                },
            },
            backgroundColor: {
                'bloom-gradient': 'linear-gradient(135deg, #FFF9F6 0%, #F8E5E8 100%)',
            },
            spacing: {
                'section': '5rem',
            },
            borderRadius: {
                'xl': '1rem',
                '2xl': '1.5rem',
                '3xl': '2rem',
            },
            boxShadow: {
                'soft': '0 2px 8px rgba(0, 0, 0, 0.08)',
                'soft-lg': '0 4px 16px rgba(0, 0, 0, 0.12)',
                'soft-hover': '0 8px 24px rgba(0, 0, 0, 0.15)',
                'inner-soft': 'inset 0 1px 3px rgba(0, 0, 0, 0.05)',
            },
            transitionDuration: {
                '300': '300ms',
            },
        },
    },

    plugins: [forms],
};
