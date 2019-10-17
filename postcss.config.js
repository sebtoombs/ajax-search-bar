module.exports = {
    syntax: 'postcss-scss',
    plugins: [
        require('postcss-import'),
        require('tailwindcss'),
        require('postcss-nested'), // or require('postcss-nesting')
        require('postcss-custom-properties'),
        require('autoprefixer'),
    ]
}