import axios from 'axios'
import store from '../main'


export default {
	namespaced: true,
	state:{

	},
	mutations:{
	},
	actions:{
		async random_players() {
			store.commit('setLoading', true)
			return await axios.get("/game/random")
			.then((res) => {
				store.commit('setLoading', false)
				return res;
			})
			.catch((error) => {
				store.commit('setLoading', false)
				console.log(error)
			})
		},
	},
	modules:{
		
	}
}