const defaultTheme = require("tailwindcss/defaultTheme");

// "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
// "./vendor/laravel/jetstream/**/*.blade.php",

module.exports = {
    purge: {
        enabled: true,
        content: [
            "./storage/framework/views/*.php",
            "./resources/views/**/*.blade.php",
        ],
        options: {
            keyframes: true,
        },
        safelist: [
            'line-through',
            'text-green-500',
            'text-red-500',
            'text-sm',
            'text-indigo-600',
            'hover:text-indigo-900',
            'text-indigo-900',
            'lg:w-1/4',
            'lg:w-2/4',
            'lg:w-3/4',
            'lg:w-4/4',
            'w-1/4',
            'w-2/4',
            'w-3/4',
            'w-4/4',
            'border-green-500',
            'bg-green-50',
            'text-green-400',
            'text-green-600',
            'border-blue-500',
            'bg-blue-50',
            'text-blue-400',
            'text-blue-600',
            'border-red-500',
            'bg-red-50',
            'text-red-400',
            'text-red-600',
            'border-yellow-500',
            'bg-yellow-50',
            'text-yellow-400',
            'text-yellow-600',
            'bg-indigo-500',
            'text-white',
            'hover:bg-indigo-100',
            'bg-indigo-100',
            'bg-indigo-50',
            'hover:bg-indigo-50',
            'bg-white',
            'py-3',
            'px-4',
            'transition-colors',
            'hover:text-black',
            'text-black',
            'inline-flex',
            'col-span-12',
            'md:border-0',
            'border-0',
            'hover:bg-gray-200',
            'transition-all',
            'duration-300',
            'ease-in-out',
            'tracking-widest',
            'bg-gray-200',
            'focus:ring-2',
            'ring-2',
            'focus:bg-blue-500',
            'bg-blue-500',
            'ring-opacity-50',
            'hover:bg-blue-600',
            'bg-blue-600',
            'py-2.5',
            'rounded-lg',
            'border-white',
            'origin-top-left',
            'left-0',
            'origin-top',
            'origin-top-right',
            '-right-24 md:right-0',
            'w-48',
            'sm:max-w-sm',
            'sm:max-w-md',
            'sm:max-w-lg',
            'sm:max-w-xl',
            'sm:max-w-2xl',
            'max-w-sm',
            'max-w-md',
            'max-w-lg',
            'max-w-xl',
            'max-w-2xl',
            'text-gray-400',
            'z-10',
            'shadow-2xl',
            'border-indigo-500',
            'p-2',
            'my-1',
            'shadow',
            'hover:shadow-md',
            'shadow-md',
            'border-t',
            'border-l',
            'border-r',
            'border-gray-200',
            'border-opacity-80',
            'cursor-pointer',
            'border-l-4',
            'lg:w-12',
            'sm:w-1/2',
            'lg:w-64',
            'shadow-lg',
            'w-0',
            'w-12',
            'w-1/2',
            'w-64',
            'lg:w-12',
            'h-full',
            'absolute',
            'right-0',
            'px-6',
            'py-5',
            'bg-gray-50',
            'bg-red-700',
            'bg-indigo-600',
            'bg-red-600',
            'hover:bg-indigo-600',
            'focus:bg-indigo-600',
            'py-2',
            'border-transparent',
            'rounded-md',
            'font-semibold',
            'text-xs',
            'focus:border-gray-900',
            'border-gray-900',
            'focus:shadow-outline-gray',
            'shadow-outline-gray',
            'disabled:opacity-25',
            'opacity-25',
            'transition',
            'ease-in-out',
            'duration-150',
            'rounded',
            'border-gray-300',
            'shadow-sm',
            'focus:border-indigo-300',
            'border-indigo-300',
            'focus:ring',
            'ring',
            'focus:ring-indigo-200',
            'ring-indigo-200',
            'focus:ring-opacity-50',
            'uppercase',
            'hover:bg-red-500',
            'bg-red-500',
            'bg-red-700',
            'focus:border-red-700',
            'focus:shadow-outline-red',
            'shadow-outline-red',
            'active:bg-red-600',
            'leading-5',
            'text-gray-700',
            'focus:bg-gray-200',
            'md:grid',
            'grid',
            'md:grid-cols-3',
            'grid-cols-3',
            'md:gap-6',
            'gap-6',
            'sm:rounded-tl-md',
            'sm:rounded-tr-md',
            'sm:rounded-md',
            'rounded-md',
            'rounded-tr-md',
            'rounded-tl-md',
            'text-gray-800',
            'px-1',
            'pt-1',
            'border-b-2',
            'border-indigo-400',
            'font-medium',
            'text-gray-900',
            'focus:outline-none',
            'outline-none',
            'focus:border-indigo-700',
            'border-indigo-700',
            'text-gray-500',
            'hover:text-gray-700',
            'hover:border-gray-300',
            'focus:text-gray-700',
            'focus:border-gray-300',
            'pl-3',
            'pr-4',
            'text-base',
            'text-indigo-700',
            'focus:text-indigo-800',
            'text-indigo-800',
            'text-gray-600',
            'focus:text-gray-800',
            'focus:bg-gray-300',
            'bg-gray-300',
            'hover:text-gray-500',
            'focus:border-blue-300',
            'border-blue-300',
            'focus:shadow-outline-blue',
            'shadow-outline-blue',
            'active:text-gray-800',
            'active:bg-gray-50',
            'hidden'
        ]
    },

    darkMode: "class",

    theme: {
        extend: {
            colors: {
                reddish: "#E879F9",
                "anti-flash": "#F6F8FA",
                "light-turnt": "#E6E6E6",
            },
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            transitionProperty: {
                width: "width",
            },
            minWidth: {
                "1/4": "25%",
                "1/2": "50%",
                "3/4": "75%",
            },
            minHeight: {
                "1/4": "25%",
                "1/2": "50%",
                "3/4": "75%",
            },
            animation: {
                wiggle: "wiggle 1s ease-in-out infinite",
                roll: "roll 3s ease-in-out infinite",
                drop: "",
            }, //this
            keyframes: {
                wiggle: {
                    "0%, 100%": { transform: "rotate(-3deg)" },
                    "50%": { transform: "rotate(3deg)" },
                },
                roll: {
                    "0%, 100%": { transform: "translateX(0) rotate(0deg)" },
                    "50%": { transform: "translateX(20rem) rotate(385deg)" },
                },
            }, //this
        },
    },

    variants: {
        extend: {
            backgroundColor: ["checked"],
            borderColor: ["checked"],
            opacity: ["disabled"],
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
