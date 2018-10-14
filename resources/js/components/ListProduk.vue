<template>
  <div class="container" style="margin-top: 70px;">
    <sui-card-group :items-per-row="4">
      <sui-card v-for="produk , index in dataProduks" :key="index">
        <sui-image :src="produk.foto"/>
        <sui-card-content extra>
          <p>Rp. {{produk.harga_jual}}</p>
          <sui-button secondary fluid>Beli Sekarang</sui-button>
        </sui-card-content>
      </sui-card>
    </sui-card-group>
  </div>
</template>

<script>
export default {
  data: () => ({
    produks: {},
    dataProduks: [],
    loading: true
  }),
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
