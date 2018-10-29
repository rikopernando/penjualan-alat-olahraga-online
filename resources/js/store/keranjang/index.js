import { SET_KERANJANG, SET_JUMLAH, SET_SEARCH_LOADING } from './mutations'

const state = {
    keranjang: {},
    jumlah: 0,
    total: 0,
    loading: true,
    searchLoading: false,
    message_table_kosong: 'Data Keranjang Kosong'
}

const getters = {
  
}

const mutations = {
    [SET_KERANJANG] (state, payload) {
      const { keranjang, pencarian } = payload
      const { data, total } = keranjang
      state.keranjang = data
      state.loading = false
      state.total = total ? total : 0
      if(!pencarian.search) state.jumlah = data.total
      if(pencarian.search && !data.data.length) {
          state.message_table_kosong = `Oopps, Tidak ada data Keranjang yang ditemukan untuk kata kunci "${pencarian.search}". Cobalah menggunakan kata kunci yang lain.`
      }
    },

    [SET_JUMLAH] (state,jumlah) {
      state.jumlah += 1
    },

    [SET_SEARCH_LOADING] (state,searchLoading) {
      state.searchLoading = searchLoading
    }
}

const actions = {

		LOAD_KERANJANG: ({commit},pencarian) => {
			commit(SET_SEARCH_LOADING,true)
			axios.get(`api/keranjangs?page=${pencarian.page}&search=${pencarian.search}&pelanggan=${pencarian.pelanggan}`)
			.then((resp) => {
				commit(SET_KERANJANG,{keranjang: resp.data, pencarian:pencarian})
			  commit(SET_SEARCH_LOADING,false)
			},
			(err) => {
				console.log(err)
			})
		},
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}


