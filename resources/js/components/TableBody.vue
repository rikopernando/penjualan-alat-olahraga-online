<template>
    <sui-table-body>
      <sui-table-row v-for="item, index in data" :key="index">
           <sui-table-cell v-for="value, i in item" :key="i">
              {{value}} 
           </sui-table-cell>
      </sui-table-row>
    </sui-table-body>
</template>

<script>
  export default {
    props: ["data"],
  }
</script>
