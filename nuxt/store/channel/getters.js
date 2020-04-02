export default {

  defaultChannelName(state) {
    return state.defaultChannelName
  },

  currentChannelName(state) {
    return state.currentChannel.name
  },

  currentChannelNameFormatted(state, getters) {
    return `#${getters.currentChannelName}`
  },

  currentChannelDescription(state) {
    return state.currentChannel.description
  },

  canLeaveChannel(state) {
    return state.currentChannel.name === state.defaultChannelName
  },

  channel(state) {
    return state.currentChannel
  },

  members(state) {
    return state.members
  },

  membersCount(state) {
    return state.members.count()
  },

  hasMessages(state) {
    return state.messages.isEmpty()
  },

  messages(state) {
    return state.messages
  },

  messagesCount(state) {
    return state.messages.count()
  },

  hasMoreMessages(state) {
    return !!state.messagesLinks.next
  },

  moreMessagesUrl(state) {
    return state.messagesLinks.next
  },

  currentMessage(state) {
    return state.currentMessage
  }

}
