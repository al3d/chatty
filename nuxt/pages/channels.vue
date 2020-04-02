<template>
  <nuxt-child keep-alive :keep-alive-props="{ key: $route.name }" />
</template>

<script>
export default {
}
</script>
