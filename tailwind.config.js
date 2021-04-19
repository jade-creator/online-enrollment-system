const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            colors: {
                'reddish': '#E879F9',
                'anti-flash': '#F6F8FA',
                'light-turnt': '#E6E6E6',
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            transitionProperty: {
                'width' : 'width'
            },
            animation: {
                wiggle: 'wiggle 1s ease-in-out infinite',
                roll: 'roll 3s ease-in-out infinite',
                drop: ''
            }, //this
            keyframes: {
                wiggle: {
                  '0%, 100%': { transform: 'rotate(-3deg)' },
                  '50%': { transform: 'rotate(3deg)' },
                },
                roll: {
                    '0%, 100%': { transform: 'translateX(0) rotate(0deg)' },
                    '50%': { transform: 'translateX(20rem) rotate(385deg)' }
                },
            }, //this
        },
    },

    variants: {
        extend: {
            backgroundColor: ['checked'],
            borderColor: ['checked'],
            opacity: ['disabled'],
        }
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
