/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                boldonse: ['"Boldonse"', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [],
}