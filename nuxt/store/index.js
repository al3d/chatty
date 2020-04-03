export const getters = {

  isLoggedIn(state) {
    return state.auth.loggedIn
  },

  user(state, getters) {
    return getters.isLoggedIn && state.auth.user
      ? state.auth.user
      : {}
  },

  hasNotifications(state, getters) {
    return !!getters.user.notifications.length
  }

}
