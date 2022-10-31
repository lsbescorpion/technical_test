import Vue from 'vue'
import Vuex from 'vuex'
import team from './team/team'
import player from './player/player'
import game from './game/game'

Vue.use(Vuex)

const store = new Vuex.Store({
	state:{
		isLoading: false
	},
	getters:{
		getLoading: state => state.isLoading
	},
	mutations:{
		setLoading(state, loading) {
			state.isLoading = loading
		}
	},
	actions:{
		
	},
	modules:{
		team,
		player,
		game
	}
});

export default store