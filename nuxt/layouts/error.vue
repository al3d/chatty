<template>
  <component :is="errorComponent" :error="error" :is-debuggable="isDebuggable" />
</template>

<script>
export default {
  components: {
    Error401: () => import('~/components/errors/401'),
    Error403: () => import('~/components/errors/403'),
    Error404: () => import('~/components/errors/404'),
    Error410: () => import('~/components/errors/410'),

  layout: 'blank',
  props: {
    error: {
      type: [Object, null],
      required: true
    }
  },
  data() {
    return {
        isDebuggable: process.env.DEBUG === 'true'
    }
  },
  computed: {
    errorComponent() {
      switch (this.error.statusCode) {
        case 401:
        case 403:
        case 404:
        case 410:
          return `Error${this.error.statusCode}`
      }
      return `Error500`
    }
  },
  mounted() {
    if (this.error && this.isDebuggable) {
      console.error(this.error.message)
    }
  }
}
</script>
