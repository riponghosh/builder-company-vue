// 专门用于处理 open jobs 页面的信息展示和更新
import Vue from 'vue'

const state = {
  job: null,
  contract: null,
  reviews: null,
  ratings: null,
}

const getters = {
  contractStatus: (state) => {
    return state.contract ? state.contract.status : null
  },
  reviewCount: (state) => {
    return state.contract ? state.contract.review_count : 0
  },
}

const mutations = {
  update(state, { job = null, contract = null, reviews = [], ratings = null }) {
    console.log(job, contract)
    state.job = job
    state.contract = contract
    state.reviews = reviews.map(i => {
      return {
        status: i.status,
        fileUrl: i.file_url,
      }
    })
    state.ratings = ratings
  },
}

const actions = {
  async reloadCurrentOpenJob({ commit, state }, id) {
    commit('update', {})
    const data = await Vue.$http.get(`/open-jobs/${id}`)
    commit('update', data)
  },
}

export default {
  state,
  getters,
  mutations,
  actions,
}
