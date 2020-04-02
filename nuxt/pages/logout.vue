<template>
  <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
        {{ pageTitle }}
      </h2>
      <transition name="fade">
        <p
          v-show="isProcessed"
          class="mt-2 text-center text-base leading-5 text-gray-600 max-w">
          <nuxt-link
            to="/login"
            class="font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
            Log back in
          </nuxt-link>
        </p>
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  auth: false,
  layout: 'public',
  data() {
    return {
      isProcessed: false,
    }
  },
  computed: {
    pageTitle() {
      if (this.isProcessed) {
        return 'Logged out'
      }
      return 'Logging you out...'
    }
  },
  head() {
    return {
      title: this.pageTitle,
    }
  },
  async mounted() {
    await this.$auth.logout()
    this.isProcessed = true
  },
}
</script>
