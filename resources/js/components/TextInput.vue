<template lang="html">
    <sui-form-field>
      <label>{{label}}</label>
      <input 
        :placeholder="placeholder"
        :type="type"
        v-bind="$attrs"
        v-bind:value="value"
        v-on:input="$emit('input', $event.target.value)"
      >
    </sui-form-field>
</template>

<script>
export default {
    inheritAttrs: false,
    props: ["label","placeholder","value","type"],
};
</script>
