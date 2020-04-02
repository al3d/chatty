<template>
  <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
        {{ pageTitle }}
      </h2>
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
      pageTitle: 'Logging your in magically...'
    }
  },
  head() {
    return {
      title: this.pageTitle,
    }
  },
  async mounted() {
    const uuid = this.$route.params.uuid
    const params = this.$route.query
    await this.$axios.get(`/auth/csrf-cookie`)
    await this.$axios.get(`/auth/magic-link/${uuid}`, { params })
    this.$router.push('/')
  }
}
</script>
