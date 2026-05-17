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
                    // Main Colors - New Pink Palette
                    'primary': '#EC91C3',           // Medium Pink
                    'primary-light': '#FECEEE',     // Light Pink
                    'primary-lighter': '#FFF0F8',   // Very light pink
                    
                    'secondary': '#DA4582',         // Hot Pink
                    'secondary-light': '#EC91C3',   // Medium Pink
                    
                    // Accent / CTA - Gold
                    'accent': '#F0CD87',            // Warm Gold
                    'accent-dark': '#D4B06A',       // Hover gold
                    'accent-light': '#F5DCA6',      // Light Gold
                    
                    // Fuchsia / Deep Pink
                    'fuchsia': '#DA4582',           // Hot Pink
                    'fuchsia-light': '#EC91C3',     // Medium Pink
                    'fuchsia-dark': '#9F254F',      // Deep Wine
                    
                    // Backgrounds
                    'bg-main': '#FFF5FA',           // Near-white pink
                    'bg-cream': '#FECEEE',          // Light pink
                    'bg-card': '#FFFFFF',           // White card
                    'bg-footer': '#9F254F',         // Deep wine footer
                    
                    // Text Colors
                    'text-primary': '#9F254F',      // Deep wine
                    'text-secondary': '#DA4582',    // Hot pink
                    'text-light': '#FFFFFF',        // White text
                    
                    // Borders & Dividers
                    'border': '#EC91C3',            // Medium pink border
                    'border-light': '#FECEEE',      // Light pink border
                    
                    // Support Colors
                    'success': '#22c55e',           // Green
                    'error': '#ef4444',             // Red
                    'warning': '#F0CD87',           // Gold
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
