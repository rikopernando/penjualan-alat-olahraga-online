import { SET_KERANJANG, SET_JUMLAH } from './mutations'

const state = {
    keranjang: {},
    jumlah: 0,
    total: 0,
    loading: true
}

const getters = {
  
}

const mutations = {
    [SET_KERANJANG] (state, keranjang) {
      const { data, total } = keranjang
      state.keranjang = data
      state.jumlah = data.total
      state.total = total ? total : 0
      state.loading = false
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


