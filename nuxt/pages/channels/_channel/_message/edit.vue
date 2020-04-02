<template>
  <Modal
    :body-classes="bodyClasses"
    @close="close">
    <div
      v-if="!loaded"
      class="text-xl font-bold text-blue-500">
      Loading...
    </div>
    <div
      v-if="!loaded"
      class="text-xl font-bold text-blue-500">
      Edit form goes here
    </div>
  </Modal>
</template>

<script>
import Modal from '~/components/modal'

export default {
  props: {
    loaded: {
      type: Boolean,
      required: false,
      default: true,
    },
  },
  components: {
    Modal,
  },
  computed: {
    bodyClasses() {
      if (this.loaded) {
        return ''
      }
      return 'bg-white rounded p-4'
    }
  },
  methods: {
    close() {
      const channel = this.$route.params.channel
      this.$router.push(`/channels/${channel}`)
    }
  }
}
</script>
