<template lang="html">
		<sui-form-field>
      <label>{{label}}</label>
				<selectize-component :settings="placeholder" v-bind="$attrs" v-bind:value="value" v-on:input="$emit('input', $event)">
						<option v-for="option, index in options" v-bind:value="option.id">
								{{ option.name }}
						</option> 
				</selectize-component>
			<sui-label basic color="red" pointing v-if="errors">{{errors[0]}}</sui-label>
      <p style="color :red; font-style:italic;" v-if="loading" > Mohon Tunggu ...</p>
		</sui-form-field>
</template>

<script>
    export default {
        inheritAttrs: false,
        props: ["label","errors","options","placeholder","value","loading"],
    };
</script>
