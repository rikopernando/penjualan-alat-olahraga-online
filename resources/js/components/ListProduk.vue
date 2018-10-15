<template>
  <div class="container" style="margin-top: 70px;">
   
    <Loading v-if="loading" />
    <sui-card-group :items-per-row="4" v-else>
      <sui-card v-for="produk , index in dataProduks" :key="index">
        <sui-image :src="produk.foto"/>
        <sui-card-content extra>
					<h6 is="sui-header" color="grey">{{produk.nama}}</h6>
          <p>Rp. {{produk.harga_jual}}</p>
          <sui-button secondary fluid>Beli Sekarang</sui-button>
        </sui-card-content>
      </sui-card>
    </sui-card-group>
    <pagination :data="produks" v-on:pagination-change-page="getProduk" :limit="4"></pagination>
  </div>
</template>

<script>

import Loading from './Loading'

export default {
  data: () => ({
    produks: {},
    dataProduks: [],
    loading: true
  }),
  components: {
    Loading
  },
  mounted(){
    const app = this
    app.getProduk()
  },
  methods: {
    getProduk(page = 1){
        const app =  this
        axios.get(`api/produks/all?page=${page}`).then((resp) => {
          app.produks = resp.data
          app.dataProduks = resp.data.data
          app.loading = false
        })
        .catch((err) => {
          app.loading = false
          alert("Gagal Memuat Data Produk")
          console.log(err)
        })
    }
  }
};
</script>
