<template>
  <div class="container" style="margin-top: 70px; 
    margin-left: 131px;">
   
    <Loading v-if="loading" />
    <sui-card-group :items-per-row="4" v-else>
      <sui-card v-for="produk , index in dataProduks" :key="index" style="width: calc(22% - 1.5em) !important">
				<a class="ui card">
            <router-link :to="{name: 'detail_produk', params: {id: produk.id}}" class="ui medium image"> 
              <sui-image :src="produk.foto">
                <sui-label slot="corner" corner="left" v-if="produk.stok == 0">
                  <sui-icon name="ban" style="color: red"/>
                </sui-label>
              </sui-image>
            </router-link>
						<sui-card-content extra>
							<h6 is="sui-header" color="grey">{{produk.nama}}</h6>
							<p>Rp. {{produk.harga_jual}}</p>
							<sui-button secondary fluid v-on:click="handleClick(produk)" v-if="auth.is_member && produk.stok == 0" disabled>Beli Sekarang</sui-button>
              <sui-button secondary fluid v-on:click="handleClick(produk)" v-else-if="auth.is_member && produk.stok > 0">Beli Sekarang</sui-button>
							<div class="ui fluid secondary button" data-tooltip="Silakan login sebagai pelanggan untuk belanja" data-position="top center" v-else-if="auth.is_owner || auth.is_admin">
								Belanja Sekarang
							</div>
							<router-link :to="{name: 'login'}" class="ui fluid secondary button" v-if="!auth.loggedIn">
								Belanja Sekarang
							</router-link>
						</sui-card-content>
	       </a>	
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
    loading: true,
    auth: {} 
  }),
  components: {
    Loading
  },
  mounted(){
    const app = this
    app.auth = app.$store.state.user
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
    },
    handleClick(produk){
      const app = this
       app.$swal({
				title: produk.nama,
				content: {
					element: "input",
					attributes: {
						placeholder: "Masukan Jumlah Produk",
						type: "number",
					},
				},
				buttons: {
					cancel: true,
					confirm: "OK"                   
				},
		 }).then((value) => {
				if (!value) throw null;
        	app.loading = true
          app.addProduk(produk.id,value)
		 }) 
    },
		addProduk(produk,jumlah){
      const app = this
      const pelanggan = app.$store.state.user.profile.id 
      axios.post('api/keranjangs',{produk:produk, jumlah:jumlah, pelanggan:pelanggan}).then((resp) => {
        const { jumlah } = resp.data
        jumlah > 0 && app.$store.commit('keranjang/SET_JUMLAH')
        app.alert("Produk dimasukan ke Keranjang Belanja")
        app.loading = false
      })
      .catch((err) => {
        app.loading = false
        alert(err)
        console.log(err)
      })
    },
    alert(pesan){
      const app = this
      app.$swal({
        text: pesan,
        icon: "success",
        buttons: false,
        timer: 1000,
      })
    }
  }
}
</script>

