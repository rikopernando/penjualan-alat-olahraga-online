<style scoped>
.title-pesanan {
   color :#050505;
   font-style:italic;
   font-size:unset;
   margin-bottom:10px;
}
.inputfile {
	width: 0.1px;
	height: 0.1px;
	opacity: 0;
	overflow: hidden;
	position: absolute;
	z-index: -1;
}
</style>

<template lang="html">
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="detail_pesanan_saya" :breadcrumb="breadcrumb" />
          <h4 class="ui dividing header">Pesanan #{{this.$route.params.id}}</h4>
          <div class="row">
            <div class="col-md-4">
              <p class="title-pesanan">Pelanggan : {{pesanan.pelanggan}}</p>
              <p class="title-pesanan">Status : {{pesanan.status_pesanan}}</p>
            </div>
            <div class="col-md-4">
              <p class="title-pesanan">Waktu Pesan : {{pesanan.waktu}}</p>
              <p class="title-pesanan">Total : Rp. {{pesanan.total}}</p>
            </div>
            <div class="col-md-4">
              <p class="title-pesanan">Bank Transfer : {{pesanan.bank_transfer}}</p>
              <p class="title-pesanan" v-if="pesanan.bukti_pembayaran">
                Bukti Pembayaran :  <a v-bind:href="pesanan.bukti_pembayaran" target="blank">Lihat Disini</a>
              </p>
              <p class="title-pesanan" v-else>
                Bukti Pembayaran : Anda belum mengirimkan bukti Pembayaran
              </p>
            </div>
          </div>
					<div class="row">
            <div class="col-md-8">
              <sui-input placeholder="Search..." icon="search" v-model="search" loading v-if="searchLoading" />
              <sui-input placeholder="Search..." icon="search" v-model="search" v-else />
            </div>
            <div class="col-md-4">
              <sui-button basic content="Batalkan" icon="remove" negative v-on:click="changeStatus(4)"/>
              <input type="file" class="inputfile" id="bukti_pembayaran" accept="image/*" v-on:change="uploadBukti()"/>
              <label for="bukti_pembayaran" class="ui basic positive button" v-if="!upload">
                <i class="ui upload icon"></i> 
                 {{pesanan.bukti_pembayaran ? 'Upload Ulang ?' : 'Upload Bukti Pembayaran'}}
              </label>
              <sui-button loading content="Loading" v-else/>
            </div>
          </div>
          <Loading v-if="loading"/>
          <sui-table striped v-else>
            <TableHeader :header="tableHeader" />
            <TableBody
              :data="dataDetail"
              labelEdit="Detail"
              edit="0" 
              hapus="0"
              v-if="dataDetail.length"/>
            <TableKosong colspan="6" :text="message_table_kosong" v-else/>
          </sui-table>
					<pagination :data="detailPesanans" v-on:pagination-change-page="getDetails" :limit="4"></pagination>
      </div>
    </div>
</template>

<script>

    import Header from '../../components/Header'
    import Breadcrumb from '../../components/Breadcrumb'
    import TableHeader from '../../components/TableHeader'
    import TableBody from '../../components/TableBody'
    import TableKosong from '../../components/TableKosong'
    import Loading from '../../components/Loading'
    import TextInput from '../../components/TextInput'

    export default {
        data: () => ({
          errors: [],
          breadcrumb: [{value: 'index',label:'Home'}, {value: 'profil',label:'Profil'}, {value: 'detail_pesanan_saya',label:'Detail Pesanan'}],
          tableHeader: ['ID','Produk','Jumlah','Harga Jual','Subtotal'],
          loading: true,
          searchLoading: false,
          search: '',
          detailPesanans: {},
          dataDetail: [],
          message_table_kosong: 'Data Detail Kosong',
          pesanan: {},
          upload: false,
        }),
        mounted(){
          const app = this
          app.findPesanan(app.$route.params.id)
        },
        components:{
          Header, Breadcrumb, TableHeader, TableBody, TableKosong, Loading, TextInput
        },
        watch: {
          search(){
              const app = this
              app.searchLoading = true
              app.getDetails()
          }
        },
        methods: {
          findPesanan(id){
            const app = this
            axios.get(`api/pesanans/${id}`).then((resp) => {
              const { data } = resp
              app.pesanan = data
              app.getDetails()
            })
            .catch((err) => {
              app.searchLoading = false
              app.loading = false
              alert("Gagal Memuat Data Penjualan")
              console.log(err)
            })
          },
          getDetails(page = 1){
            const app = this
            const id = app.$route.params.id
            axios.get(`api/detail-pesanans?page=${page}&search=${app.search}&id=${id}`)
            .then((resp) => {
              app.detailPesanans = resp.data
              app.dataDetail = resp.data.data
              app.searchLoading = false
              app.loading = false
              if(!app.detailPesanans.data.length && app.search){ 
                app.message_table_kosong = `Oopps, Tidak ada data Detail Penjualan yang ditemukan untuk kata kunci "${app.search}". Cobalah menggunakan kata kunci yang lain.`
              }
            })
            .catch((err) => {
              app.searchLoading = false
              app.loading = false
              alert("Gagal Memuat Data Produk")
              console.log(err)
            })
          },
          changeStatus(status_pesanan){
            const app = this 
            app.$swal({
								text: "apakah anda yakin ?",
								buttons: {
									cancel: true,
									confirm: "OK"                   
								},
						}).then((value) => {
								if (!value) throw null
                app.updateStatus(status_pesanan)
						}) 
          },
          updateStatus(status_pesanan){
            const app = this
            const id = app.$route.params.id
            axios.put(`api/pesanans/${id}`,{status_pesanan: status_pesanan}).then((resp) => {
              app.pesanan.button_status = resp.data.button_status
              app.pesanan.status_pesanan = resp.data.status
              app.pesanan.status = app.pesanan.status == 4 ? 2 : app.pesanan.status + 1
              app.alert("Berhasil Mengupdate Status Pesanan")
            })
            .catch((err) => {
              alert("Gagal Update Status")
              console.log(err)
            })
          },
          uploadBukti(e){
            const app = this
            const id = app.$route.params.id
            const data = new FormData()
						if (document.getElementById('bukti_pembayaran').files[0] != undefined) {
							data.append('bukti_pembayaran', document.getElementById('bukti_pembayaran').files[0])
						}
            app.upload = true
            axios.post(`api/pesanan-saya/upload-bukti-bayar/${id}`,data).then((resp) => {
              app.pesanan.bukti_pembayaran = resp.data.data
              app.alert("Berhasil Mengupload Bukti Pembayaran")
              app.upload = false
            })
            .catch((err) => {
              alert("Gagal Update Status")
              app.upload = false
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
  };
</script>
