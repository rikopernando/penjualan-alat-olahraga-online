<template>
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="detail_produk" :breadcrumb="breadcrumb" />
          <br />
          <br />
          <Loading v-if="loading"/>
          <sui-grid class="inverted" stackable divided v-else>
            <sui-grid-row>
              <sui-grid-column :width="5">
                <sui-card class="black">
                 <sui-image :src="previewFoto" bordered/>
                </sui-card>
              </sui-grid-column>
              <sui-grid-column :width="5">
                <h4 class="ui dividing header">{{produks.nama}}</h4>
								<h6 is="sui-header" color="black">Rp. {{produks.harga_jual | currency }}</h6>
								<p>{{produks.deskripsi}}</p>
								<sui-dropdown
									:options="produks.warna"
									placeholder="Pilihan Warna"
									search
									selection
									v-model="pesanans.warna"
								/>
              </sui-grid-column>
              <sui-grid-column :width="5">
								<br />
								<p>Jumlah Kuantitas</p>
								<sui-button attached="left" icon="minus" v-on:click="lessProduk()"/>
								<div class="ui input">
									<input type="number" placeholder="Jumlah Produk" v-model="pesanans.jumlah_produk" style="text-align:center;">
								</div>
								<sui-button attached="right" icon="plus" v-on:click="addProduk()"/>
                <p style="color :red; font-style:italic;margin-top:25px;">Sisa Produk : {{produks.stok}}</p>
								<div style="margin-top:25px;">
										<sui-button primary>Beli Sekarang</sui-button>
										<sui-button secondary>Tambah ke Keranjang</sui-button>
							  </div>	
              </sui-grid-column>
            </sui-grid-row>
          </sui-grid>
         <br />
        </div>
      <Footer v-if="!loading"/>
    </div>
</template>

<script>

    import Header from '../../components/Header'
    import Breadcrumb from '../../components/Breadcrumb'
    import Loading from '../../components/Loading'
    import Footer from '../../components/Footer'
    import { mapState } from 'vuex'

    export default {
        data: () => ({
          breadcrumb: [{value: 'index',label:'Home'}, {value: 'detail_produk',label:'Detail Produk'}],
          search: '',
          produks: {},
          previewFoto: null,
          loading: true,
          pesanans: {
              warna: null,
              jumlah_produk: 1,	
          }
        }),
        mounted(){
          const app = this
          app.findProduk(app.$route.params.id)
        },
        watch : {
          'pesanans.jumlah_produk' : function(){
             const app = this
            if(app.pesanans.jumlah_produk == 0){
              app.pesanans.jumlah_produk = 1
            }else if(app.pesanans.jumlah_produk > app.produks.stok){
              app.pesanans.jumlah_produk = app.produks.stok
            }
          }
        },
        components:{
          Header, Breadcrumb, Loading, Footer
        },
				filters: {
					currency(value) {
						let angka = [value];
						let numberFormat = new Intl.NumberFormat('es-ES');
						let formatted = angka.map(numberFormat.format);
						return formatted.join('; ');
					},
				},
        methods:{
          findProduk(id){
            const app = this
            axios.get(`api/produks/${id}`).then((resp) => {
              const { data } = resp
              app.produks.nama = data.nama
              app.produks.harga_jual = data.harga_jual
              app.produks.deskripsi = data.deskripsi
              app.produks.stok = data.stok
              app.previewFoto = data.previewFoto
              if(data.warna){ 
                app.produks.warna = []
                data.warna.split(",").forEach((warna) => {
                    app.produks.warna.push({
                      key: warna, value: warna, text: warna         
                    })  
                })
              }else{
                app.produks.warna = []
              }
              app.loading = false
            })
            .catch((err) => {
              console.log(err)
              app.loading = false
              alert(err)
            })
          },
          lessProduk(){
            const app = this
            app.pesanans.jumlah_produk = parseInt(app.pesanans.jumlah_produk) - 1
          },
          addProduk(){
            const app = this
            app.pesanans.jumlah_produk = parseInt(app.pesanans.jumlah_produk) + 1
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
    };
</script>
