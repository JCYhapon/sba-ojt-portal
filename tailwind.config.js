/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            minHeight: {
                "80vh": "80vh",
                "70vh": "70vh",
            },
        },
    },
    plugins: [require("flowbite/plugin")],
};
