import axios from 'axios'
import store from '../main'


export default {
	namespaced: true,
	state:{

	},
	mutations:{
	},
	actions:{
		async list() {
			store.commit('setLoading', true)
			return await axios.get("/team/list")
			.then((res) => {
				store.commit('setLoading', false)
				return res;
			})
			.catch((error) => {
				store.commit('setLoading', false)
				console.log(error)
			})
		},

		async store(_,form) {
			store.commit('setLoading', true)
			return await axios.post("/team/store", form)
			.then(() => {
				store.commit('setLoading', false)
			})
			.catch((error) => {
				store.commit('setLoading', false)
				console.log(error)
			})
		},

		async delete(_,id) {
			store.commit('setLoading', true)
			return await axios.post("/team/delete", id)
			.then(() => {
				store.commit('setLoading', false)
			})
			.catch((error) => {
				store.commit('setLoading', false)
				console.log(error)
			})
		},

		async edit(_,id) {
			store.commit('setLoading', true)
			return await axios.get("/team/edit/"+id)
			.then((res) => {
				store.commit('setLoading', false)
				return res
			})
			.catch((error) => {
				store.commit('setLoading', false)
				console.log(error)
			})
		},

		async update(_,form) {
			store.commit('setLoading', true)
			return await axios.post("/team/update", form)
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