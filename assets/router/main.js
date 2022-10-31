import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home'
import Team from '../views/team/team'
import TeamUpdate from '../views/team/update'
import Player from '../views/player/player'
import PlayerUpdate from '../views/player/update'

Vue.use(VueRouter)

const routes = [
	{
		path: '/home',
		name: 'Home',
		component: Home
	},
	{
		path: '/team',
		name: 'Team',
		component: Team
	},
	{
		path: '/player',
		name: 'Player',
		component: Player
	},
	{
		path: '/team/update/:id',
		name: 'Team.Update',
		component: TeamUpdate,
		method: 'GET'
	},
	{
		path: '/player/update/:id',
		name: 'Player.Update',
		component: PlayerUpdate,
		method: 'GET'
	}
]

const router = new VueRouter({
	mode: 'history',
	routes
})

export default router