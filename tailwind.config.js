const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */

module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        colors: {
            "m-orange-l": "#F3954B",
            "m-orange": "#F28A37",
            "m-orange-d": "#C16E2C",
            "m-blue-l": "#557479",
            "m-blue": "#43656B",
            "m-blue-d": "#355055",
            "m-red-d": "#e53935",
        },
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
                "roboto-l": ["roboto-light", ...defaultTheme.fontFamily.sans],
                roboto: ["roboto-regular", ...defaultTheme.fontFamily.sans],
                "roboto-m": ["roboto-medium", ...defaultTheme.fontFamily.sans],
                "roboto-b": ["roboto-bold", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
