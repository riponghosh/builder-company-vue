import qs from 'qs'
import axios from 'axios'
import { Message } from 'element-ui'

const instance = axios.create({
  baseURL: '/v1',
})

instance.interceptors.request.use((config) => {
  return config
})

instance.interceptors.response.use((res) => {
    const vue = window.vue
    const code = res.data.code
    switch (code) {
      case (1000):
        return res.data.data
      case ('UNAUTHORIZED'): {
        vue.$router.push('/login')
        throw new axios.Cancel('Needs Login')
      }
      default: {
        Message.error(res.data.message)
        throw new axios.Cancel(res.data)
      }
    }
  },
  (error) => {
    Message.error('Network Error')
    return Promise.reject(error)
  }
)

export default instance
