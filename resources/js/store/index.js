import Vue from 'vue'
import Vuex from 'vuex'
import user from './user'
import otoritas from './otoritas'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    awesome: true
  },
  modules : {
    user,otoritas
  }
})

export default store

