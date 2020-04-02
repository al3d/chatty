import collect from 'collect.js'
import defaultState from './state'

export default {

  setChannel(state, data) {
    state.currentChannel = data
  },

  setMembers(state, data) {
    state.members = collect(data)
  },

  setMessages(state, data) {
    state.messages = collect(data)
  },

  setMessagesLinks(state, data) {
    state.messagesLinks = data
  },

  setMessagesMeta(state, data) {
    state.messagesMeta = data
  },

  appendMessages(state, data) {
    const messages = state.messages.all()
    state.messages = collect(messages.concat(data))
  },

  prependMessage(state, data) {
    const messages = state.messages.prepend(data)
    /*
      Making it unique because websocket event is fired for every user even though
      we're trying to broadcast to other users only. I think its an error with
      nuxt-community/laravel-echo, but also could be axios not setting the header
      and my workaround isn't working.
    */
    state.messages = messages.unique('uuid')
  },

  replaceMessage(state, data) {
    state.messages = state.messages.map(item => {
      if (item.uuid === data.uuid) {
        return data
      }
      return item
    })
  },

  removeMessage(state, uuid) {
    state.messages = state.messages.map(item => {
      if (item.uuid === uuid) {
        item.is_deleted = true
        item.message = null
      }
      return item
    })
  },

  setCurrentMessage(state, data) {
    state.currentMessage = data
  },

  clearMembers(state) {
    state.members = defaultState().members
  },

  clearMessages(state) {
    state.messages = defaultState().messages
  },

  clearCurrentMessage(state) {
    state.currentMessage = defaultState().currentMessage
  },

}
