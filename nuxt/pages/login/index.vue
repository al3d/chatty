<template>
  <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
        {{ pageTitle }}
      </h2>
    </div>

    <div
      v-if="isMagicLinkConfirmScreen"
      class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <p class="text-lg leading-relaxed text-gray-600">
              We've just sent you a magic link to automatically log in you into Chatty. Check your inbox (including your spam folder).
          </p>
        </div>
      </div>
    </div>

    <div
      v-else
      class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form
          autocomplete="off"
          @submit.prevent="actOnSubmit">

          <div>
            <label
              for="email"
              class="block text-sm font-medium leading-5 text-gray-700">
              Email address
            </label>
            <div class="mt-1 rounded-md shadow-sm">
              <input
                id="email"
                v-model="form.email"
                type="email"
                required
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
            </div>
          </div>

          <transition name="fade">
            <div
              v-if="isRegisterScreen"
              class="mt-6">
              <label
                for="name"
                class="block text-sm font-medium leading-5 text-gray-700">
                Your Name
              </label>
              <div class="mt-1 rounded-md shadow-sm">
                <input
                  id="name"
                  v-model="form.name"
                  type="name"
                  required
                  class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
              </div>
            </div>
          </transition>

          <transition name="fade">
            <div
              v-if="isLoginScreen"
              class="mt-6">
              <label
                for="password"
                class="block text-sm font-medium leading-5 text-gray-700">
                Password
              </label>
              <div class="mt-1 rounded-md shadow-sm">
                <input
                  id="password"
                  v-model="form.password"
                  type="password"
                  required
                  class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
              </div>
            </div>
          </transition>

          <!-- <transition name="fade">
            <div
              v-if="isLoginScreen"
              class="mt-6 flex items-center justify-between">
              <div class="flex items-center">
                <input
                  v-model="form.remember"
                  id="remember_me"
                  type="checkbox"
                  class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out">
                <label
                  for="remember_me"
                  class="ml-2 block text-sm leading-5 text-gray-900">
                  Remember me
                </label>
              </div>
            </div>
          </transition> -->

          <div class="mt-6">
            <span class="block w-full rounded-md shadow-sm">
              <button
                type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out">
                {{ actionButtonText }}
              </button>
            </span>
          </div>

          <transition name="fade">
            <div
              v-if="isLoginScreen"
              class="mt-6">
              <span class="block w-full rounded-md shadow-sm">
                <button
                  type="button"
                  class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-500 focus:outline-none focus:border-pink-700 focus:shadow-outline-blue active:bg-teal-700 transition duration-150 ease-in-out"
                  @click="requestMagicLink">
                  Send me a magic link
                </button>
              </span>
            </div>
          </transition>

          <transition name="fade">
            <div
              v-if="currentScreen"
              class="mt-6 text-center text-sm leading-5 text-gray-600 max-w">
              <div
                class="cursor-pointer font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150"
                @click="reset">
                Start again
              </div>
            </div>
          </transition>

        </form>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  auth: false,
  layout: 'public',
  middleware({ store, redirect }) {
    if (store.getters.isLoggedIn) {
      redirect('/')
    }
  },
  data() {
    return {
      currentScreen: null,
      form: {
        name: '',
        email: '',
        password: '',
        remember: false,
      },
    }
  },
  head() {
    return {
      title: this.pageTitle,
    }
  },
  computed: {
    pageTitle() {
      switch (true) {
        case this.isLoginScreen:
          return 'Log in'
        case this.isRegisterScreen:
          return 'Register'
        case this.isMagicLinkConfirmScreen:
          return 'Magic Link Sent'
      }
      return 'Get Started with Chatty'
    },
    isMagicLinkConfirmScreen() {
      return this.currentScreen === 'magic-confirm'
    },
    isRegisterScreen() {
      return this.currentScreen === 'register'
    },
    isLoginScreen() {
      return this.currentScreen === 'login'
    },
    actionButtonText() {
      switch (true) {
        case this.isLoginScreen:
          return 'Log in'
        case this.isRegisterScreen:
          return 'Register'
      }
      return 'Start'
    }
  },
  methods: {
    async actOnSubmit() {
      switch (true) {
        case this.isLoginScreen:
          return await this.login()
        case this.isRegisterScreen:
          return await this.register()
      }
      return await this.start()
    },
    async start() {
      await this.$axios.get(`/auth/csrf-cookie`)
      const response = await this.$axios.$post(`/auth/start`, {
        email: this.form.email,
      })
      if (response.exists) {
        this.currentScreen = 'login'
        return
      }
      this.currentScreen = 'register'
    },
    async register() {
      // validate
      await this.$axios.post(`/auth/register`, {
        name: this.form.name,
        email: this.form.email,
      })
      await this.$auth.fetchUser()
      // notify
      this.$router.push(`/`)
    },
    async login() {
      // validate
      await this.$auth.loginWith('local', {
        data: {
          email: this.form.email,
          password: this.form.password,
          remember: this.form.remember,
        },
      })
      // notify
      this.$router.push(`/`)
    },
    async requestMagicLink() {
      // validate email
      await this.$axios.post(`/auth/login`, {
        email: this.form.email,
        magic_link: true,
      })
      // notify
      this.currentScreen = 'magic-confirm'
    },
    reset() {
      this.currentScreen = null
    },
  },
}
</script>
