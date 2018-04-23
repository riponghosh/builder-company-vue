import Vue from './lib/vue'
import router from './router'
import store from './store'
import App from './App.vue'
window.vue = new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App },
})
