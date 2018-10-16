import Vue from 'vue'
import Vuex from 'vuex'
import user from './user'
import otoritas from './otoritas'
import keranjang from './keranjang'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    awesome: true
  },
  modules : {
    user,otoritas,keranjang
  }
})

export default store

