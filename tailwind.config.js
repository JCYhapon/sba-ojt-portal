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
            screens: {
                xs: "390px",
                ss: "620px",
                sm: "768px",
                ssm: "900px",
                md: "1060px",
                mmd: "1100px",
                lg: "1200px",
                llg: "1400px",
                xl: "1700px",
            },
        },
    },
    plugins: [require("flowbite/plugin")],
};
