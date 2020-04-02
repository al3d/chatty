<script>
export default {
  /**
   * For this simple demo, we're just going to redirect
   * to the #general channel
   */
  middleware({ store, redirect }) {
    if (store.getters.isLoggedIn) {
      redirect('/channels/general')
    }
  },
}
</script>
