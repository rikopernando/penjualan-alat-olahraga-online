<template>
	<form id="logout-form" v-bind:action="url + 'logout'" method="POST" style="display: none;">
	  <input type="hidden" name="_token" v-bind:value="token">
	</form>
</template>

<script>

export default {
	data: () => ({
		url : window.location.origin + window.location.pathname,
		token : $('meta[name="csrf-token"]').attr('content'),
	}),
	mounted() {
    document.getElementById('logout-form').submit();
    this.$store.commit('user/LOGOUT')
	}
}

</script>
