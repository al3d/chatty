<template>
  <div class="modal">
    <div
      v-if="showContent"
      :style="bodyStyles"
      :class="bodyClasses"
      class="modal-body">
      <slot />
      <div
        v-if="showCloseButton"
        :style="closeButtonStyles"
        :class="closeButtonClasses"
        class="modal-close"
        @click="close">
        <svg
          focusable="false"
          viewBox="0 0 320 512"
          class="modal-close-icon">
          <path
            class="modal-close-times"
            d="M207.6 256l107.72-107.72c6.23-6.23 6.23-16.34 0-22.58l-25.03-25.03c-6.23-6.23-16.34-6.23-22.58 0L160 208.4 52.28 100.68c-6.23-6.23-16.34-6.23-22.58 0L4.68 125.7c-6.23 6.23-6.23 16.34 0 22.58L112.4 256 4.68 363.72c-6.23 6.23-6.23 16.34 0 22.58l25.03 25.03c6.23 6.23 16.34 6.23 22.58 0L160 303.6l107.72 107.72c6.23 6.23 16.34 6.23 22.58 0l25.03-25.03c6.23-6.23 6.23-16.34 0-22.58L207.6 256z"
          />
        </svg>
      </div>
    </div>
    <div
      :style="bgStyles"
      :class="bgClasses"
      class="modal-bg"
      @click="close" />
  </div>
</template>

<script>
export default {
  props: {
    showContent: {
      type: Boolean,
      required: false,
      default: true,
    },
    showCloseButton: {
      type: Boolean,
      required: false,
      default: false,
    },
    zIndex: {
      type: Number,
      required: false,
      default: 8888,
    },
    bgColor: {
      type: String,
      required: false,
      default: 'rgba(0, 0, 0, .75)',
    },
    bodyClasses: {
      type: String,
      required: false,
      default: 'bg-white rounded p-4',
    },
  },
  data() {
    return {
      overflow: null,
      bodyStyles: {
        'z-index': this.zIndex + 1,
      },
      bgStyles: {
        'z-index': this.zIndex,
        'background-color': this.bgColor,
      },
      closeButtonStyles: {
        'z-index': this.zIndex + 2,
      },
    }
  },
  computed: {
    bgClasses() {
      return ''
    },
    closeButtonClasses() {
      return ''
    },
  },
  beforeMount() {
    document.addEventListener('keyup', this.escHandler)
  },
  beforeDestroy() {
    document.removeEventListener('keyup', this.escHandler)
  },
  methods: {
    escHandler(event) {
      if (event.keyCode === 27) {
        this.close()
      }
    },
    close() {
      this.$emit('close')
    }
  },
}
</script>

<style lang="postcss">
.modal-body {
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  position: fixed;
}

.modal-bg {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}

.modal-close {
  @apply absolute p-1 rounded-full bg-white top-0 right-0 cursor-pointer;

  transform: translate(50%, -50%);
}

.modal-close-icon {
  @apply w-6 h-6;
}

.modal-close-times {
  fill: theme('colors.gray.300');
}

.modal-close:hover .modal-close-times,
.modal-close:focus .modal-close-times {
  fill: theme('colors.gray.900');
}

</style>
