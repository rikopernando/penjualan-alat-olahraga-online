import { LOAD_DATA, GET_PROVINSI, GET_KABUPATEN, GET_KECAMATAN, GET_KELURAHAN } from './mutations'

const state = {
    load_kabupaten : false,
    load_kecamatan : false,
    load_kelurahan : false,
    provinsi : [],
    kabupaten : [],
    kecamatan : [],
    kelurahan : [],
}

const getters = {
}

const mutations = {
    [GET_PROVINSI] (state, provinsi) {
      state.provinsi = provinsi
    },

    [GET_KABUPATEN] (state, kabupaten) {
      state.kabupaten = kabupaten.data 
      state.load_kabupaten = false
    },

    [GET_KECAMATAN] (state, kecamatan) {
      state.kecamatan = kecamatan.data 
      state.load_kecamatan = false
    },

    [GET_KELURAHAN] (state, kelurahan) {
      state.kelurahan = kelurahan.data 
      state.load_kelurahan = false
    },

    [LOAD_DATA] (state,data) {
				switch (data.type) {
						case "kabupaten":
                state.load_kabupaten = true
								break;
						case "kecamatan":
                state.load_kecamatan = true
								break;
						case "kelurahan":
                state.load_kelurahan = true
								break;
				}
    }

}

const actions = {
    LOAD_PROVINSI : ({commit}) => {
      axios.get('api/lokasi/provinsi')
      .then((resp) => {
        commit(GET_PROVINSI, resp.data)
      })
      .catch((err) => {
        console.log(err)
      })
    },

    LOAD_WILAYAH : ({commit},wilayah) => {
      commit(LOAD_DATA,{type: wilayah.type})
      axios.get(`api/lokasi/pilih-wilayah/${wilayah.id}/${wilayah.type}`)
      .then((resp) => {
        const payload = {data : resp.data}
				switch (wilayah.type) {
						case "kabupaten":
                commit(GET_KABUPATEN, payload)
								break;
						case "kecamatan":
                commit(GET_KECAMATAN, payload)
								break;
						case "kelurahan":
                commit(GET_KELURAHAN, payload)
								break;
				}

      })
      .catch((err) => {
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


