<template lang="html">
  <sui-message :header="header" :list="errors" />
</template>

<script>
    export default {
        props: ['errors','header'] 
    };
</script>

