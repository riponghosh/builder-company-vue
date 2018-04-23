import moment from 'moment'

const state = {
  currentSessionId: 1,
  chats: [{
    id: 1,
    user: {
      name: 'Sample',
      img: 'http://via.placeholder.com/150x150?text=LOL',
    },
    messages: [{
      content: 'Hello, world',
      date: moment()
    },]
  }, {
    id: 2,
    user: {
      name: 'Sample2',
      img: 'http://via.placeholder.com/150x150?text=LOL',
    },
    messages: []
  }],
}

const getters = {
  currentChat: state => {
    return state.chats.find(i => i.id === state.currentSessionId)
  }
}

const mutations = {
  sendMessage({ chats, currentSessionId }, content) {
    chats.find(item => item.id === currentSessionId)
         .messages
         .push({
           content: content,
           date: new Date(),
           self: true
         })
  },
  selectSession(state, id) {
    state.currentSessionId = id
  },
}

const actions = {
  sendMessage: ({ commit }, content) => {
    commit('sendMessage', content)
  },
  selectSession: ({ commit }, id) => {
    commit('selectSession', id)
  },
}

export default {
  state,
  getters,
  mutations,
  actions,
}
