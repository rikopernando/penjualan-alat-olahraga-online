import { SET_OTORITAS } from './mutations'

const state = {
    otoritas : []
}

const getters = {
  
}

const mutations = {
    [SET_OTORITAS] (state,otoritas) {
      state.otoritas = otoritas
    }
}

const actions = {

		LOAD_OTORITAS : function({commit}){
			axios.get('api/otoritas')
			.then((resp) => {
				commit(SET_OTORITAS,resp.data)
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


