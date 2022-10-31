<template>
	<div class="row justify-content-center">
		<div class="card col-md-8 mt-5">
	  		<div class="card-body">
				<form @submit.prevent="submit">
					<div class="mb-3">
						<label class="h4">Game</label>
					</div>
					<div class="mb-3">
						<label class="">Punctuation: <span id="puntuation">{{puntuation}}</span></label>
					</div>
					<div class="mb-3">
						<label class="">Rest players: <span id="player">{{rplayer}}</span></label>
					</div>
					<div class="mb-3">
					    <label for="name" class="form-label">Name</label>
					    <input type="text" class="form-control" id="name" v-model="form.name">
					</div>
					<div class="mb-3">
					    <label for="color" class="form-label">Team</label>
					    <select class="form-select" v-model="form.team">
						  	<option v-for="(key, index) in teams" :value="key.id">{{key.name}}</option>
						</select>
						<span class="text-danger">{{error}}</span>
					</div>
					<button type="submit" class="btn btn-primary mr-2" :disabled="disabled">{{validate}}</button>
					<button type="button" @click="ResartGame()" class="btn btn-primary" v-show="disabled">Resart Game</button>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
import {mapActions} from 'vuex';
export default {
	name: "Home",
	data() {
		return {
			teams: [],
			players: [],
			rplayer: 0,
			pos: 0,
			puntuation: 0,
			error: '',
			validate: 'Validate game',
			disabled: false,
			form: {
				name: '',
				team: ''
			}
		};
	},
	methods: {
		...mapActions({
			list: "team/list",
			random_players: "game/random_players"
		}),

		listTeams() {
			this.list().then((res) => {
				this.teams = JSON.parse(res.data.teams);
			})
			.catch((error) => {
				console.log(error);
			})
		},

		getRandomPlayers() {
			this.form.name = "Loading...."
			this.random_players().then((res) => {
				this.players = JSON.parse(res.data.players);
				this.form.name = this.players[0].name;
				this.pos = 0;
				this.rplayer = 10;
				this.puntuation = 0;
			})
			.catch((error) => {
				console.log(error);
			})
		},

		submit() {
			this.error = '';
			if(this.form.team == '' || this.form.team == null) {
				this.error = 'Please select the TEAM';
				return;
			}
			else {
				let p = this.players[this.pos];
				if(p.team.id == this.form.team) {
					this.puntuation = this.puntuation + 1;
					this.rplayer = this.rplayer - 1;
					this.pos = this.pos + 1;
				}
				else
				if(p.team.id != this.form.team) {
					this.puntuation = this.puntuation - 1;
					this.rplayer = this.rplayer - 1;
					this.pos = this.pos + 1;
				}
			}
			if(this.pos != 10)
				this.form.name = this.players[this.pos].name;
			if(this.rplayer == 0) {
				this.validate = 'End Game!';
				this.disabled = true;
			}
		},

		ResartGame() {
			this.getRandomPlayers();
			this.disabled = false;
			this.validate = 'Validate game';
		}
	},
	mounted() {
		this.listTeams();
		this.getRandomPlayers();
	}
};
</script>

<style>

</style>