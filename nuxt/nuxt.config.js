export default {

    /*
     **
     */
    env: {
        DEBUG: process.env.DEBUG || 'true',
        IS_LOCAL: process.env.IS_LOCAL || 'false',
        API_BASE: process.env.API_BASE || 'http://localhost',
    },

    /*
     ** Universal mode will hopefully work, if now, this should be
     ** set to 'spa'
     */
    mode: 'universal',

    // generate: {
    //     fallback: true,
    // },

    /*
     ** Headers of the page
     */
    head: {
        titleTemplate(titleChunk) {
            return titleChunk ? `${titleChunk} - Chatty` : `Chatty`
        },
        meta: [
            { charset: 'utf-8' },
            { name: 'viewport', content: 'width=device-width, initial-scale=1' },
            {
                hid: 'description',
                name: 'description',
                content: 'A quicky-chatty app'
            }
        ],
        link: [
            { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
        ],
    },

    /*
     ** Customize the progress-bar color
     */
    loading: {
        color: '#333333',
    },

    /*
     ** Loading indicator - a little fun
     */
    loadingIndicator: {
        name: 'chasing-dots',
        color: '#333333',
        background: '#FFFFFF',
    },

    /*
     ** Global CSS
     */
    css: [],

    /*
     ** Plugins to load before mounting the App
     */
    plugins: [
        '~/plugins/axios',
    ],

    /*
     ** Router configuration
     */
    router: {
        middleware: ['auth'],
    },

    /*
     ** Nuxt.js dev-modules
     */
    buildModules: [
        '@nuxtjs/eslint-module', // https://github.com/nuxt-community/eslint-module
        '@nuxtjs/stylelint-module', // https://github.com/nuxt-community/stylelint-module
        '@nuxtjs/tailwindcss', // https://github.com/nuxt-community/nuxt-tailwindcss
    ],

    /*
     ** Nuxt.js modules
     ** Doc: https://axios.nuxtjs.org/usage
     */
    modules: [
        '@nuxtjs/axios',
        '@nuxtjs/pwa'
    ],

    /*
     ** Axios module configuration
     ** See https://axios.nuxtjs.org/options
     */
    axios: {
        baseURL: `${process.env.API_BASE}`,
        debug: process.env.debug === 'true',
        withCredentials: true,
    },

    /*
     ** Nuxt Auth module configuration
     ** See https://auth.nuxtjs.org
     */
    auth: {
        strategies: {
            resetOnError: true,
            fullPathRedirect: true,
            rewriteRedirects: true,
            redirect: {
                login: '/login',
                logout: '/logout',
                home: '/',
                callback: '/login',
            },
            local: {
                endpoints: {
                    login: {
                        url: '/auth/login',
                        method: 'post',
                        withCredentials: true,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                        },
                    },
                    logout: {
                        url: '/auth/logout',
                        method: 'post',
                        withCredentials: true,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                        },
                    },
                    user: {
                        url: '/auth/me',
                        method: 'get',
                        propertyName: 'user',
                        withCredentials: true,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                        },
                    },
                },
                tokenRequired: false,
                tokenType: false,
            }
        }
    },

    /*
     ** Build configuration
     */
    build: {
        /*
         ** You can extend webpack config here
         */
        extend(config, ctx) { }
    }
}
