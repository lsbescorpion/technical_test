import axios from 'axios'
import store from '../main'


export default {
	namespaced: true,
	state:{

	},
	mutations:{
	},
	actions:{
		async list_player() {
			store.commit('setLoading', true)
			return await axios.get("/player/list")
			.then((res) => {
				store.commit('setLoading', false)
				return res;
			})
			.catch((error) => {
				store.commit('setLoading', false)
				console.log(error)
			})
		},

		async store_player(_,form) {
			store.commit('setLoading', true)
			return await axios.post("/player/store", form)
			.then(() => {
				store.commit('setLoading', false)
			})
			.catch((error) => {
				store.commit('setLoading', false)
				console.log(error)
			})
		},

		async delete_player(_,id) {
			store.commit('setLoading', true)
			return await axios.post("/player/delete", id)
			.then(() => {
				store.commit('setLoading', false)
			})
			.catch((error) => {
				store.commit('setLoading', false)
				console.log(error)
			})
		},

		async edit_player(_,id) {
			store.commit('setLoading', true)
			return await axios.get("/player/edit/"+id)
			.then((res) => {
				store.commit('setLoading', false)
				return res
			})
			.catch((error) => {
				store.commit('setLoading', false)
				console.log(error)
			})
		},

		async update_player(_,form) {
			store.commit('setLoading', true)
			return await axios.post("/player/update", form)
			.then(() => {
				store.commit('setLoading', false)
			})
			.catch((error) => {
				store.commit('setLoading', false)
				console.log(error)
			})
		}
	},
	modules:{
		
	}
}