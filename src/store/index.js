import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

import user from './modules/user'
import config from './modules/config'
import openJob from './modules/open-job'
import chat from './modules/chat'

Vue.use(Vuex)

const state = {
}

const store = new Vuex.Store({
  plugins: [createPersistedState()],
  state,
  modules: {
    user,
    config,
    openJob,
    chat,
  },
})

export default store
