import { LOGIN, LOGOUT } from './mutations'

const state = {
    profile : {},
    loggedIn : false,
    is_admin : false,
    is_owner : false
}

const getters = {
  
}

const mutations = {
    [LOGIN] (state, user) {
      if(user.role.role_id == "1"){
       state.is_owner = true
      }
      if(user.role.role_id == "2"){
       state.is_admin = true
      }
      state.loggedIn = true
      state.profile = user 
    },

    [LOGOUT] (state) {
      state.is_admin = false
      state.is_owner= false
      state.loggedIn = false
      state.profile = {}
      localStorage.removeItem("api_token")
    }
}

const actions = {

}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}


