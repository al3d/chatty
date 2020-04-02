<template>
  <Modal @close="close">
    <div class="channel-name-users">
      <div
        v-for="member in members"
        :key="member.uuid"
        class="m-2">
        <p class="m-2">{{ member.name }}</p>
      </div>
    </div>
  </Modal>
</template>

<script>
import { mapGetters } from 'vuex'
import Modal from '~/components/modal'

export default {
  components: {
    Modal,
  },
  fetchOnServer: false,
  async fetch() {
    const channel = this.$route.params.channel
    await this.$nuxt.context.store.dispatch('channel/loadMembers', channel)
  },
  computed: {
    ...mapGetters('channel', [
      'members'
    ]),
  },
  methods: {
    close() {
      const channel = this.$route.params.channel
      this.$router.push(`/channels/${channel}`)
    }
  }
}
</script>
