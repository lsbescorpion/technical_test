<template>
	<div class="row justify-content-center">
		<div class="card col-md-8 mt-5">
	  		<div class="card-body">
				<form @submit.prevent="submit">
					<div class="mb-3">
					    <label for="name" class="form-label">Name</label>
					    <input type="text" class="form-control" id="name" v-model="form.name">
					</div>
					<div class="mb-3">
					    <label for="color" class="form-label">Position</label>
					    <select class="form-select" aria-label="Default select example" v-model="form.position">
						  	<option v-for="pos in positions" :value="pos">{{pos}}</option>
						</select>
					</div>
					<div class="mb-3">
					    <label for="color" class="form-label">Team</label>
					    <select class="form-select" v-model="form.team">
						  	<option v-for="(key, index) in teams" :value="key.id">{{key.name}}</option>
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Accept</button>
				</form>
			</div>
		</div>

		<div class="card col-md-8 mt-5">
	  		<div class="card-body">
				<table class="table table-hover">
					<thead>
					    <tr>
					      	<th scope="col">#</th>
					      	<th scope="col">Name</th>
					      	<th scope="col">Position</th>
					      	<th scope="col">Team</th>
					      	<th scope="col align-self-end">Actions</th>
					    </tr>
					</thead>
					<tbody>
					    <tr v-if="players.length > 0" v-for="(key, index) in players" :style="'background: ' + key.team.hexColor">
					      	<td class="col-1">{{index + 1}}</td>
					      	<td class="col-3">{{key.name}}</td>
					      	<td class="col-2">{{key.position}}</td>
					      	<td class="col-3">{{key.team.name}}</td>
					      	<td class="col-3 align-self-end">
					      		<button type="button" @click="UpdatePlayer(key.id)" class="btn btn-outline-primary">Edit</button>
					      		<button type="button" @click="DeletePlayer(key.id)" class="btn btn-outline-primary">Delete</button>
					      	</td>
					    </tr>
					    <tr v-if="players.length == 0" class="text-center">
					      	<td colspan="3">No data Found</td>
					    </tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
import {mapActions} from 'vuex';
export default {
	name: "Player",
	data() {
		return {
			teams: [],
			players: [],
			positions: ['goalkeeper', 'defending', 'midfield', 'forward'],
			form: {
				name: '',
				position: '',
				team: ''
			}
		};
	},
	methods: {
		...mapActions({
			list: "team/list",
			list_player: "player/list_player",
			store_player: "player/store_player",
			delete_player: "player/delete_player",
		}),

		listTeams() {
			this.list().then((res) => {
				this.teams = JSON.parse(res.data.teams);
				console.log(this.teams);
			})
			.catch((error) => {
				console.log(error);
			})
		},

		listPlayers() {
			this.list_player().then((res) => {
				this.players = JSON.parse(res.data.players);
			})
			.catch((error) => {
				console.log(error);
			})
		},

		submit() {
			this.store_player(this.form).then(() => {
				console.log("create");
				this.listPlayers();
				this.form.name = '';
			})
			.catch((error) => {
				console.log(error);
			})
		},

		DeletePlayer(id) {
			this.delete_player(id).then(() => {
				console.log("delete");
				this.listPlayers();
			})
			.catch((error) => {
				console.log(error);
			})
		},

		UpdatePlayer(id) {
			this.$router.push('/player/update/'+id);
		}
	},
	mounted() {
		this.listPlayers();
		this.listTeams();
	}
};
</script>

<style>

</style>