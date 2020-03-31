<template>
  <div class="channel-name-message">
    <nuxt-child :key="$route.name" />
  </div>
</template>

<script>
export default {
  // validate() {
  //     // @todo
  // },
  async asyncData({ params }) {
    return {
      messageId: params.message
    }
  }
}
</script>

<template>
  <div class="channel-name">{{ channelName }}</div>
</template>

<script>
export default {
  async asyncData({ params }) {
    return {
      channelName: params.name
    }
  }
}
</script>
