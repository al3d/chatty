<template>
  <nuxt-child
    keep-alive
    :keep-alive-props="{ key: $route.name }"
    :loaded="!$fetchState.pending" />
</template>

<script>
export default {
  fetchOnServer: false,
  async fetch() {
    const uuid = this.$route.params.message
    const channelName = this.$route.params.channel
    await this.$nuxt.context.store.dispatch('channel/loadMessage', { uuid, channelName })
  },
}
</script>
