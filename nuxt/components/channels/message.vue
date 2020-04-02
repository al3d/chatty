<template>
  <div class="p-4 m-4 rounded-lg bg-white border border-gray-400 shadow-sm flex">
    <div class="flex flex-col justify-between">
        <span
          :title="user.name"
          :style="{ 'background-color': `#${userColor}` }"
          class="cursor-default inline-flex items-center justify-center h-12 w-12 rounded-full border-2 border-white text-white">
          <span class="text-base font-medium leading-none tracking-wider">{{ userInitials }}</span>
        </span>
    </div>
    <div class="ml-4 w-full">
      <div class="flex justify-between">
        <span
          :style="{ 'color': `#${userColor}` }"
          class="cursor-default text-lg font-bold">
          {{ userName }}
        </span>
        <span class="text-sm font-medium text-gray-500 leading-5">
          <nuxt-link
            v-if="showInfo"
            :to="`/channels/${channel}/${uuid}`"
            :title="updatedAt ? createdAt : null"
            class="text-gray-500">
            {{ updatedAt ? updatedAt : createdAt }}
          </nuxt-link>
          <span
            v-else
            class="cursor-default text-gray-500">
            {{ updatedAt ? updatedAt : createdAt }}
          </span>
          <nuxt-link
            v-if="isOwner && showEdit"
            :to="`/channels/${channel}/${uuid}/edit`"
            class="ml-4 hover:text-blue-500 focus:outline-none focus:underline">
            Edit
          </nuxt-link>
        </span>
      </div>
      <div class="mt-2">
        <div
          v-if="isDeleted"
          class="italic text-gray-400">
          This message was deleted
        </div>
        <div v-else>
          {{ message }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import formatDistanceToNow from 'date-fns/formatDistanceToNow'

export default {
  props: {
    data: {
      type: Object,
      required: true,
    },
    showEdit: {
      type: Boolean,
      required: false,
      default: true,
    },
    showInfo: {
      type: Boolean,
      required: false,
      default: true,
    },
  },
  computed: {
    ...mapGetters([
      'user',
    ]),
    uuid() {
      return this.data.uuid
    },
    channel() {
      return this.data.channel
    },
    createdAt() {
      return this.formattedDate(this.data.created_at)
    },
    updatedAt() {
      return this.data.updated_at ? this.formattedDate(this.data.updated_at) : null
    },
    message() {
      return this.data.message
    },
    userUuid() {
      return this.data.user.uuid
    },
    userName() {
      return this.data.user.name
    },
    userInitials() {
      return this.data.user.initials
    },
    userColor() {
      return this.data.user.color
    },
    isOwner() {
      return this.userUuid === this.user.uuid
    },
    isDeleted() {
      return this.data.is_deleted
    },
  },
  methods: {
    formattedDate(dateStr) {
      return formatDistanceToNow(new Date(dateStr), { includeSeconds: true })
    }
  }
}
</script>
