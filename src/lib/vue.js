import Vue from 'vue'
import moment from 'moment'
import VueChatScroll from 'vue-chat-scroll'

import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/en'
import '../theme/index.scss'


import axios from './axios'
import Raven from 'raven-js'
import RavenVue from 'raven-js/plugins/vue'

if (process.env.NODE_ENV === 'production') {
  Raven.config('https://2cb04befe7034058914d80b80b1508f7@sentry.io/228043')
       .addPlugin(RavenVue, Vue)
       .install()
}

import VueStripeCheckout from 'vue-stripe-checkout'

const options = {
  key: 'pk_test_6eYotmhLMqmKjknysju9BsK0',
  image: 'https://cdn.meme.am/images/100x100/15882140.jpg',
  locale: 'auto',
  currency: 'USD',
  billingAddress: false,
  panelLabel: 'Top up'
}

Vue.use(VueStripeCheckout, options);

// config
Vue.config.productionTip = false

// plugin
Vue.use(ElementUI, { locale })
Vue.use(VueChatScroll)

// lib
Vue.$http = axios
Vue.prototype.$http = axios
Vue.prototype.$moment = moment

// handle error
Vue.prototype.handleError = (error) => {
  console.error(error)
  Vue.prototype.$Notice.error({
    title: 'Server Error',
    desc: error.message,
    duration: 0,
  })
}

export default Vue
