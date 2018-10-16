<template lang="html">
    <sui-form-field>
      <label>{{label}}</label>
			<textarea v-if="type == 'textarea'"
        :placeholder="placeholder" 
        rows="3"
        v-bind="$attrs"
        v-bind:value="value"
        v-on:input="$emit('input', $event.target.value)">
      </textarea>	
      <input v-else
        :id="id"
        :placeholder="placeholder"
        :type="type"
        v-bind="$attrs"
        v-bind:value="value"
        v-on:input="$emit('input', $event.target.value)"
      >
			<sui-label basic color="red" pointing v-if="errors">{{errors[0]}}</sui-label>
    </sui-form-field>
</template>

<script>
export default {
    inheritAttrs: false,
    props: ["label","placeholder","value","type","id","errors"],
};
</script>
