export const state = () => {
  return {
    socketId: null,
  }
}

export const actions = {
  initSocket({ commit }, socketId) {
    commit('setSocketId', socketId)
  }
}

export const mutations = {
  setSocketId(state, socketId) {
    state.socketId = socketId
  }
}

export const getters = {

  socketId(state) {
    return state.socketId
  },

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
