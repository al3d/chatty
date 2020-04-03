export default function ({ $axios, app }) {
  $axios.onRequest(config => {
    if (app.$echo) {
      config.headers['X-Socket-ID'] = app.$echo.socketId()
    }
    config.headers['Accept'] = 'application/json'
    config.headers['Content-Type'] = 'application/json'
    config.headers['X-Requested-With'] = 'XMLHttpRequest'
    config.withCredentials = true
  })
}
