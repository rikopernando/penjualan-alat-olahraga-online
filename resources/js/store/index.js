import Vue from 'vue'
import Vuex from 'vuex'
import user from './user'
import otoritas from './otoritas'
import keranjang from './keranjang'
import lokasi from './lokasi'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    awesome: true
  },
  modules : {
    user,otoritas,keranjang,lokasi
  }
})

export default store

