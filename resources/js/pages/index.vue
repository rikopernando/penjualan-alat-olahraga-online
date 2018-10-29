<template>
    <div>
      <Header />
      <sui-container fluid>
        <ListProduk />
      </sui-container>
      <Footer />
    </div>
</template>

<script>
  import Header from '../components/Header'
  import ListProduk from '../components/ListProduk'
  import Footer from '../components/Footer'

  export default {
    components:{
      Header,ListProduk, Footer
   }
  }
</script>
