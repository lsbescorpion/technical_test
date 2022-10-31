<template>
	<nav class="navbar navbar-expand-lg" style="background-color: #e3f2fd;">
		<div class="container-fluid">
	    	<a class="navbar-brand" href="#">Test</a>
	   		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			   	<span class="navbar-toggler-icon"></span>
			</button>
		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
				    <li class="nav-item">
				        <router-link class="nav-link active" aria-current="page" to="/home">Game</router-link>
				    </li>
				    <li class="nav-item">
				        <router-link class="nav-link active" aria-current="page" to="/team">Team</router-link>
				    </li>
				    <li class="nav-item">
				        <router-link class="nav-link active" aria-current="page" to="/player">Player</router-link>
				    </li>
			    </ul>
		   	</div>
	  	</div>
	</nav>
</template>

<script>
export default {
	name: "NavBar"
};
</script>

<style>

</style>