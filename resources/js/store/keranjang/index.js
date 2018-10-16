import { SET_KERANJANG, SET_JUMLAH } from './mutations'

const state = {
    keranjang: {},
    jumlah: 0
}

const getters = {
  
}

const mutations = {
    [SET_KERANJANG] (state, keranjang) {
      state.keranjang = keranjang
      state.jumlah = keranjang.data.length
    },

    [SET_JUMLAH] (state,jumlah) {
      state.jumlah += 1
    }
}

const actions = {

		LOAD_KERANJANG : function({commit}){
			axios.get('api/keranjangs')
			.then((resp) => {
				commit(SET_KERANJANG,resp.data)
			},
			(err) => {
				console.log(err)
			})
		}
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}


