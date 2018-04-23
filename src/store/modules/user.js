import Vue from 'vue'

const state = {
  id: null,
  username: null,
  type: null,
  amount: null,

  openJobs: [],
  appliedJobs: [],
  appliedArtists: [],

  savedArtists: [],
}

const getters = {
  isLoggedIn: (state) => {
    return state.username !== null
  },
  isArtist: (state) => {
    return state.username !== null && state.type === 'artist'
  },
  isEmployer: (state) => {
    return state.username !== null && state.type === 'employer'
  },
}

const mutations = {
  reset(state) {
    state.id = null
    state.username = null
    state.type = null
    state.amount = null

    state.openJobs = []
    state.appliedJobs = []
    state.appliedArtists = []

    state.savedArtists = []
  },
  login(state, { id, username, type }) {
    state.id = id
    state.username = username
    state.type = type
  },
  updateSideBar(state, { openJobs = [], appliedJobs = [], appliedArtists = [], amount = null }) {
    state.amount = amount || 0
    state.openJobs = openJobs.map(i => {
      return {
        id: i.id,
        projectName: i.project_name,
      }
    })
    state.appliedJobs = appliedJobs.map(i => {
      return {
        id: i.id,
        jobTitle: i.job_title,
        projectName: i.project_name,
        userId: i.userId,
        timeType: i.timeType,
        site: i.site,
        budget: i.budget,
        experience: i.experience,
        info: i.info,
        location: i.location,
        category: i.category,
        companyLink: i.company_link,
        companyName: i.company_name,
        employmentType: i.employment_type,
        status: i.status,
        isConfidential: i.is_confidential,
        createdAt: i.created_at,
        updatedAt: i.updated_at,
        deadline: i.deadline,
        bonusPoints: i.bonusPoints,
        skills: i.skills,
        images: i.images,
        artist: {
          id: i.artist.user_id,
          firstName: i.artist.first_name,
          lastName: i.artist.last_name,
          rating: i.artist.rating,
          hourlyRate: i.artist.hourly_rate,
          experience: i.artist.experience,
          portfolios: i.artist.portfolios || [],
          clients: i.artist.clients,
          categories: i.artist.categories || [],
          skills: i.artist.skills,
          jobTypes: i.artist.job_types,
          site: i.artist.site,
        }
      }
    })
    state.appliedArtists = appliedArtists.map(i => {
      const job = i.job
      const applyingArtists = i.applying_artists ? i.applying_artists : []
      return {
        job: {
          id: job.id,
          title: `${job.category} Designer`,
          subtitle: `${job.employer.company_name} looking for ${job.site} ${ job.time_type } ${ job.category } Designer`,
          projectName: job.project_name,
          category: job.category,
          budget: job.budget,
          skills: job.skills,
          experience: job.experience,
          deadline: job.deadline,
          location: job.location,
          companyName: job.employer.company_name,
          isConfidential: job.is_confidential,
          bonnusPoints: job.bonus_points,
          info: job.info,
          userId: job.user_id,
        },
        applyingArtists: applyingArtists.map(i => {
          return {
            id: i.user_id,
            avatar: i.avatar,
            firstName: i.first_name,
            lastName: i.last_name,
            rating: i.rating,
            hourlyRate: i.hourly_rate,
            experience: i.experience,
            portfolios: i.portfolios || [],
            clients: i.clients,
            categories: i.categories || [],
            skills: i.skills,
            jobTypes: i.job_types,
            site: i.site,
            proposal: i.proposal.content,
          }
        }),
      }
    })
  },
  updateSavedArtists(state, { savedArtists = [] }) {
    state.savedArtists = savedArtists.map(i => {
      return {
        id: i.user_id,
        avatar: i.avatar,
        firstName: i.first_name,
        lastName: i.last_name,
        rating: i.rating,
        hourlyRate: i.hourly_rate,
        experience: i.experience,
        portfolios: i.portfolios || [],
        clients: i.clients,
        categories: i.categories || [],
        skills: i.skills,
        jobTypes: i.job_types,
        site: i.site,
      }
    })
  },
}

const actions = {
  async login({ commit, state }, { username, password }) {
    const data = await Vue.$http.post(`/user/login`, {
      username: username,
      password: password,
    })
    commit('login', {
      username: username,
      type: data.type,
      id: data.id,
    })
    return null
  },
  async signup({ commit, state, dispatch }, { username, password, type }) {
    const data = await Vue.$http.post(`/user/sign-up`, {
      username: username,
      password: password,
      type: type,
    })
    // return await dispatch('login', {
      // username: username,
      // password: password,
    // })
  },
  async activate({ commit, state }, { id, authKey }) {
    const data = await Vue.$http.post(`/user/activate`, {
      id: id,
      authKey: authKey
    })
  },
  async logout({ commit, state }) {
    commit('reset')
  },
  async updateSideBar({ commit, state, getter }) {
    const data = await Vue.$http.get(`/account`)
    let appliedJobs = []
    let appliedArtists = []
    if (state.type === 'artist') {
      const artist = await Vue.$http.get(`/${state.type}s/${state.id}`)
      appliedJobs = data.applied_jobs.map(i => {
        return Object.assign(i, { artist: artist })
      })
    }
    if (state.type === 'employer') {
      appliedArtists = data.applying_jobs
    }

    commit('updateSideBar', {
      amount: data.amount,
      openJobs: data.open_jobs,
      appliedJobs: appliedJobs,
      appliedArtists: appliedArtists,
    })

    if (getters.isEmployer(state)) {
      const savedArtists = await Vue.$http.get('/saved-artists')
      commit('updateSavedArtists', {
        savedArtists: savedArtists,
      })
    }
  },
}

export default {
  state,
  getters,
  mutations,
  actions,
}
