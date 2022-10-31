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
					    <select class="form-select" v-model="form.team.id">
						  	<option v-for="(key, index) in teams" :value="key.id">{{key.name}}</option>
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Accept</button>
				</form>
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
			positions: ['goalkeeper', 'defending', 'midfield', 'forward'],
			form: {
				name: '',
				position: '',
				team: '',
				id: ''
			}
		};
	},
	methods: {
		...mapActions({
			list: "team/list",
			edit_player: "player/edit_player",
			update_player: "player/update_player",
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

		submit() {
			this.update_player(this.form).then(() => {
				console.log("update");
				this.$router.push('/player');
			})
			.catch((error) => {
				console.log(error);
			})
		},
	},
	mounted() {
		this.edit_player(this.$route.params.id).then((res) => {
			let player = JSON.parse(res.data.player);
			this.form = player;
		})
		.catch((error) => {
			console.log(error);
		})
		this.listTeams();
	}
};
</script>

<style>

</style>