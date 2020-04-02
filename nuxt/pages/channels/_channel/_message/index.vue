<template>
  <Modal
    :body-classes="bodyClasses"
    @close="close">
    <div
      v-if="!loaded"
      class="text-xl font-bold text-blue-500">
      Loading...
    </div>
    <Message
      v-else
      :data="currentMessage"
      :show-info="false"
      :show-edit="false" />
  </Modal>
</template>

<script>
import { mapGetters } from 'vuex'
import Message from '~/components/channels/message'
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
    Message,
    Modal,
  },
  computed: {
    ...mapGetters('channel', [
      'currentMessage'
    ]),
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
