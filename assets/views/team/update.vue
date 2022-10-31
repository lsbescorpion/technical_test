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
	</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
	name: "TeamUpdate",
	data() {
		return {
			form: {
				name: '',
				hexColor: '',
				id: ''
			}
		};
	},
	computed: {
	},
	methods: {
		...mapActions({
			edit: "team/edit",
			update: "team/update",
		}),

		submit() {
			this.update(this.form).then(() => {
				console.log("update");
				this.$router.push('/team');
			})
			.catch((error) => {
				console.log(error);
			})
		},

	},
	mounted() {
		console.log(this.$route.params.id);
		this.edit(this.$route.params.id).then((res) => {
			let team = JSON.parse(res.data.team);
			this.form = team;
		})
		.catch((error) => {
			console.log(error);
		})
	}
};
</script>

<style>

</style>