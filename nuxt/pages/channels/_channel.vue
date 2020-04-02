<template>
  <div class="bg-gray-200 min-h-full">
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl leading-tight">
          <span class="font-bold text-blue-700 mr-2">
            Chatty
          </span>
          <span class="font-bold text-gray-900">
            {{ channelTitle }}
          </span>
          <span class="text-gray-400 ml-2">
            {{ channelDescription }}
          </span>
        </h1>
      </div>
    </header>
    <section>
      <div class="bg-blue-700 border-t border-gray-200 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <div class="max-w-6xl mx-auto">
            <form
              autocomplete="off"
              class="bg-white p-3 mx-4 rounded-lg flex justify-between"
              @submit.prevent="postMessage">
              <div class="flex-1 rounded-md shadow-sm border border-gray-400 ">
                <textarea
                  v-model="form.message"
                  placeholder="Tell us what you think..."
                  class="textarea">
                </textarea>
              </div>
              <div class="flex-shrink-0 ml-4">
                <div class="flex flex-col">
                  <button
                    type="submit"
                    class="inline-flex items-center px-8 py-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-blue active:bg-blue-700">
                    Send
                  </button>
                  <nuxt-link
                    :to="`/channels/${channelName}/members`"
                    class="text-xs text-center text-blue-400 hover:text-blue-700 hover:underline mt-2">
                    Members
                  </nuxt-link>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
          <div
            v-if="$fetchState.pending"
            class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="p-6 text-center text-2xl font-bold text-blue-900">
              Loading...
            </h2>
          </div>
          <div
            v-else
            class="py-1">
            <Message
              v-for="item in messages"
              :key="item.uuid"
              :data="item" />
            <div class="p-3 pt-0">
            <button
              v-if="hasMoreMessages"
              type="button"
              class="mx-auto block px-6 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-indigo-700 transition ease-in-out duration-150"
              @click="loadMoreMessages">
              Load more messages
            </button>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--
      a nuxt-child here allows us to nicely
      build modals while keeping aa deep url
      structure.
    -->
    <nuxt-child keep-alive :keep-alive-props="{ key: $route.name }" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Message from '~/components/channels/message'

export default {
  components: {
    Message,
  },
  fetchOnServer: false,
  async fetch() {
    try {
      await this.$nuxt.context.store.dispatch('channel/loadChannel', this.$route.params.channel)
    } catch (e) {
      this.$nuxt.context.error({ statusCode: 404, message: 'Channel not found'})
    }
  },
  data() {
    return {
      form: {
        message: null,
      }
    }
  },
  computed:{
    /**
     * This is a way to get the channel/currentChannelName getter and alias it
     * to channelName. The first argument is the namespace, the second argument
     * is an *object* that signifies the aliasing e.g. the currentChannelName
     * getter in the currentChannelName (namespaced) vuex store is now aliased
     * to this.channelName
     */
    ...mapGetters('channel', {
      'channelName': 'currentChannelName'
    }),
    /**
     * This is a way to get the channel/* getters. It doesn't alias them. The first
     * argument is the namespace, and the second argument is an array of getters. This
     * means they're not aliased and can be accessed directly e.g. this.messages
     */
    ...mapGetters('channel', [
      'currentChannelNameFormatted',
      'currentChannelDescription',
      'messages',
      'hasMoreMessages',
    ]),
    /**
     * This is a way to map the root getters. An array or object as a first argument
     * (instead of a string) means we're referring to the root store (store/index.js)
     */
    ...mapGetters([
      'user',
    ]),
    channelTitle() {
      return this.$fetchState.pending ? 'loading...' : this.currentChannelNameFormatted
    },
    channelDescription() {
      return this.$fetchState.pending ? '' : this.currentChannelDescription
    }
  },
  head() {
    return {
      title: this.currentChannelNameFormatted,
    }
  },
  async beforeMount() {
    this.$echo.channel(`channel.${this.$route.params.channel}`)
      .listen('.message.created', ev => {
        this.$store.dispatch('channel/realtimeCreated', ev)
      })
      .listen('.message.updated', ev => {
        console.log('received:updated', ev)
        this.$store.dispatch('channel/realtimeUpdated', ev)
      })
      .listen('.message.deleted', ev => {
        this.$store.dispatch('channel/realtimeDeleted', ev)
      })
    await this.$store.dispatch('initSocket', this.$echo.socketId())
  },
  methods: {
    async postMessage() {
      await this.$store.dispatch('channel/postMessage', this.form.message)
      // notify
      this.form.message = ''
    },
    async loadMoreMessages() {
      await this.$store.dispatch('channel/loadMoreMessages')
    },
  },
}
</script>

<style lang="postcss">
.textarea {
  /*
    Here I'm demonstrating how we can extract css components from tailwind
  */
  @apply rounded-md w-full mr-4 outline-none h-16 p-2;

  /*
    I want to prevent resizing of the textarea element, and this removes
    the bottom-right handler browsers display
  */
  resize: none;
}
</style>
