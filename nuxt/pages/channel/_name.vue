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
