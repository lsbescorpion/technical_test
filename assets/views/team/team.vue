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
					    <label for="color" class="form-label">Color</label>
					    <input type="color" id="hex_color" v-model="form.hexColor" value="#000000">
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
					      	<th scope="col align-self-end">Actions</th>
					    </tr>
					</thead>
					<tbody>
					    <tr v-if="teams.length > 0" v-for="(key, index) in teams" :style="'background: ' + key.hexColor">
					      	<td class="col-1">{{index + 1}}</td>
					      	<td class="col-7">{{key.name}}</td>
					      	<td class="col-4 align-self-end">
					      		<button type="button" @click="UpdateTeam(key.id)" class="btn btn-outline-primary">Edit</button>
					      		<button type="button" @click="DeleteTeam(key.id)" class="btn btn-outline-primary">Delete</button>
					      	</td>
					    </tr>
					    <tr v-if="teams.length == 0" class="text-center">
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
	name: "Team",
	data() {
		return {
			teams: [],
			form: {
				name: '',
				hexColor: ''
			}
		};
	},
	computed: {
	},
	methods: {
		...mapActions({
			list: "team/list",
			store: "team/store",
			delete: "team/delete",
		}),

		listTeams() {
			this.list().then((res) => {
				this.teams = JSON.parse(res.data.teams);
			})
			.catch((error) => {
				console.log(error);
			})
		},

		submit() {
			this.store(this.form).then(() => {
				console.log("create");
				this.listTeams();
				this.form.name = '';
			})
			.catch((error) => {
				console.log(error);
			})
		},

		DeleteTeam(id) {
			this.delete(id).then(() => {
				console.log("delete");
				this.listTeams();
			})
			.catch((error) => {
				console.log(error);
			})
		},

		UpdateTeam(id) {
			this.$router.push('/team/update/'+id);
		}
	},
	mounted() {
		this.listTeams();
	}
};
</script>

<style>

</style>