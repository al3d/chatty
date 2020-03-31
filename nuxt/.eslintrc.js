module.exports = {
    root: true,
    env: {
        browser: true,
        node: true
    },
    parserOptions: {
        parser: 'babel-eslint'
    },
    extends: [
        '@nuxtjs',
        'prettier',
        'prettier/vue',
        'plugin:prettier/recommended',
        'plugin:nuxt/recommended'
    ],
    plugins: [
        'prettier'
    ],
    rules: {
        // These rules help me focus after over a year of coding vue
        "vue/html-self-closing": ["error", {
            "html": {
                "void": "never",
                "normal": "always",
                "component": "any"
            },
            "svg": "always",
            "math": "always"
        }],
        "vue/max-attributes-per-line": [2, {
            "singleline": 2,
            "multiline": {
                "max": 1,
                "allowFirstLine": false
            }
        }]
    }
}
