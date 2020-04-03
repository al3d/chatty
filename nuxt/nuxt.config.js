require('dotenv').config()

export default {

  /*
   **
   */
  env: {
    API_BASEURL: process.env.API_BASEURL,
    DEBUG: process.env.DEBUG,
    IS_LOCAL: process.env.IS_LOCAL,
    PUSHER_KEY: process.env.PUSHER_KEY,
    LOCALSOCKETS_KEY: process.env.LOCALSOCKETS_KEY,
    LOCALSOCKETS_CLUSTER: process.env.LOCALSOCKETS_CLUSTER,
    LOCALSOCKETS_HOST: process.env.LOCALSOCKETS_HOST,
    LOCALSOCKETS_PORT: process.env.LOCALSOCKETS_PORT,
    LOCALSOCKETS_ENCRYPTED: process.env.LOCALSOCKETS_ENCRYPTED,
  },

  mode: 'spa',

  generate: {
    fallback: true
  },

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
    color: '#3182CE',
  },

  /*
   ** Loading indicator - a little fun
   */
  loadingIndicator: {
    name: 'chasing-dots',
    color: '#3182CE',
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
    '@nuxtjs/auth',
    '@nuxtjs/axios',
    '@nuxtjs/pwa'
  ],

  /*
   ** Axios module configuration
   ** See https://axios.nuxtjs.org/options
   */
  axios: {
    baseURL: process.env.API_BASEURL,
    debug: process.env.DEBUG === 'true',
    credentials: true,
  },

  /*
   ** Nuxt Auth module configuration
   ** See https://auth.nuxtjs.org
   */
  auth: {
    strategies: {
      fullPathRedirect: true,
      local: {
        endpoints: {
          login: {
            url: '/auth/login',
            method: 'post',
          },
          logout: {
            url: '/auth/logout',
            method: 'post',
          },
          user: {
            url: '/api/me',
            method: 'get',
            propertyName: 'data',
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
    devtools: process.env.DEBUG === 'true',

    /*
     ** You can extend webpack config here
     */
    extend(config, ctx) { }
  }
}
