import Vue from 'vue'
import axios from 'axios'

export default function ({ $axios }) {

    // Adding the ability to cancel req uests
    const CancelToken = axios.CancelToken

    Vue.prototype.$axiosCancelToken = CancelToken.source()

    Vue.prototype.$axiosRefreshCancelToken = () => {
        Vue.prototype.$axiosCancelToken = CancelToken.source()
    }

    $axios.onRequest(config => {
        config.headers['Accept'] = 'application/json'
        config.headers['Content-Type'] = 'application/json'
        // @todo - add withCredentials here
        config.cancelToken = Vue.prototype.$axiosCancelToken.token
    })
}
