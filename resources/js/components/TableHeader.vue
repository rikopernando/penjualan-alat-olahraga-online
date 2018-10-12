<template>
    <sui-table-header>
      <sui-table-row>
        <sui-table-header-cell v-for="header, index in header" :key="index">
          {{header}} 
        </sui-table-header-cell>
      </sui-table-row>
    </sui-table-header>
</template>

<script>
  export default {
    props: ['header']
  }
</script>
