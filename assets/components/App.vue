<template>
	<div>
		<NavBar :show="isLoading"/>
		<router-view></router-view>
	</div>
</template>

<script>
import NavBar from './NavBar'
import {mapGetters} from 'vuex'
export default {
	name: "App",
	components: {
		NavBar,
	},
	computed: {
		...mapGetters({
			isLoading: 'getLoading'
		})
	},
	mounted() {
	},
};
</script>

<style>

</style>