export default function ({ $axios, store }) {
  $axios.onRequest(config => {
    if (store.getters.socketId) {
      config.headers['X-Socket-ID'] = store.getters.socketId
    }
    config.headers['Accept'] = 'application/json'
    config.headers['Content-Type'] = 'application/json'
    config.headers['X-Requested-With'] = 'XMLHttpRequest'
    config.withCredentials = true
  })
}
