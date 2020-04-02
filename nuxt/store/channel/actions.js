export default {

  async loadChannel({ commit, dispatch }, channelName) {
    const response = await this.$axios.$get(`/api/channels/${channelName}`)
    commit('setChannel', response.data)
    // commit('setMembers', response.data.members)
    dispatch('loadMessages')
    commit('clearMessages')
  },

  async createChannel({ commit, dispatch }, { name, description }) {
    const response = await this.$axios.$post(`/api/channels`, { name, description })
    commit('setChannel', response.data)
    dispatch('loadMessages')
    commit('clearCurrentMessage')
  },

  async updateChannel({ commit, getters }, description) {
    const response = await this.$axios.$patch(`/api/channels/${getters.currentChannelName}`, { description })
    commit('setChannel', response.data)
  },

  async deleteChannel({ commit, getters, dispatch }) {
    await this.$axios.$delete(`/api/channels/${getters.currentChannelName}`)
    commit('clearChannel')
    dispatch('loadChannel', getters.defaultChannelName)
  },

  async leaveChannel({ getters, dispatch }) {
    if (!getters.canLeaveChannel) {
      return
    }
    await this.$axios.patch(`/api/channels/${getters.currentChannelName}/leave`)
    dispatch('loadChannel', getters.defaultChannelName)
  },

  async loadMembers({ commit, getters }, channelName) {
    channelName = channelName || getters.currentChannelName
    const response = await this.$axios.$get(`/api/channels/${channelName}/members`)
    commit('setMembers', response.data)
  },

  async loadMessages({ commit, getters }) {
    const response = await this.$axios.$get(`/api/channels/${getters.currentChannelName}/messages`)
    commit('setMessages', response.data)
    commit('setMessagesLinks', response.links)
    commit('setMessagesMeta', response.meta)
  },

  async loadMoreMessages({ commit, getters }) {
    if (!getters.hasMoreMessages) {
      return
    }
    const response = await this.$axios.$get(getters.moreMessagesUrl)
    commit('appendMessages', response.data)
    commit('setMessagesLinks', response.links)
    commit('setMessagesMeta', response.meta)
  },

  async loadMessage({ commit, getters }, { uuid, channelName }) {
    channelName = channelName || getters.currentChannelName
    const response = await this.$axios.$get(`/api/channels/${channelName}/messages/${uuid}`)
    commit('setCurrentMessage', response.data)
  },

  async postMessage({ commit, getters }, message) {
    const response = await this.$axios.$post(`/api/channels/${getters.currentChannelName}/messages`, { message })
    commit('prependMessage', response.data)
    commit('setCurrentMessage', response.data)
  },

  async updateMessage({ commit, getters, dispatch }, { uuid, message }) {
    if (!getters.message || getters.message.uuid !== uuid) {
      await dispatch('loadMessage', { uuid })
    }
    const response = await this.$axios.$patch(`/api/channels/${getters.currentChannelName}/messages/${uuid}`, { message })
    commit('replaceMessage', response.data)
    commit('setCurrentMessage', response.data)
  },

  async deleteMessage({ commit }, uuid) {
    await this.$axios.$delete(`/api/channels/${getters.currentChannelName}/messages/${uuid}`)
    commit('removeMessage', uuid)
    commit('clearCurrentMessage')
  },

  realtimeCreated({ commit }, data) {
    commit('prependMessage', data)
  },

  realtimeUpdated({ commit }, data) {
    commit('replaceMessage', data)
  },

  realtimeDeleted({ commit }, { uuid }) {
    commit('removeMessage', uuid)
  }

}
