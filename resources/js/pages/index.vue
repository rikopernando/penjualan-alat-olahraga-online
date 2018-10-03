<template>
    <div>
      <Header />
      <sui-container fluid>
        <ListProduk />
      </sui-container>
    </div>
</template>

<script>
  import Header from '../components/Header'
  import ListProduk from '../components/ListProduk'

  export default {
    components:{
      Header,ListProduk
   }
  }
</script>
