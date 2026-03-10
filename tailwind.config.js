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
                display: ['Sora', 'sans-serif'],
                body: ['Inter', 'sans-serif'],
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand:  { DEFAULT:'#0F4CDB', light:'#3B6FF0', dark:'#0A35A3' },
                accent: '#00D4AA',
                ink:    { DEFAULT:'#0D1117', muted:'#6B7280', faint:'#9CA3AF' },
                surface:'#F7F8FC',
                border: '#E5E8F0',
            },
            backgroundImage: {
                'grid-dots': "linear-gradient(to right, rgba(15,76,219,0.06) 1px, transparent 1px), linear-gradient(to bottom, rgba(15,76,219,0.06) 1px, transparent 1px)",
            },
            backgroundSize: {
                'grid': '48px 48px',
            },
            keyframes: {
                'pulse-dot': {
                    '0%,100%': { opacity: '1', transform: 'scale(1)' },
                    '50%':     { opacity: '0.6', transform: 'scale(1.4)' },
                },
                'fade-up': {
                    from: { opacity: '0', transform: 'translateY(24px)' },
                    to:   { opacity: '1', transform: 'translateY(0)' },
                },
            },
            animation: {
                'pulse-dot': 'pulse-dot 2s ease-in-out infinite',
                'fade-up-1': 'fade-up 0.65s 0.10s cubic-bezier(0.22,1,0.36,1) both',
                'fade-up-2': 'fade-up 0.65s 0.22s cubic-bezier(0.22,1,0.36,1) both',
                'fade-up-3': 'fade-up 0.65s 0.36s cubic-bezier(0.22,1,0.36,1) both',
                'fade-up-4': 'fade-up 0.65s 0.50s cubic-bezier(0.22,1,0.36,1) both',
            },
        },
    },

    plugins: [forms],
};