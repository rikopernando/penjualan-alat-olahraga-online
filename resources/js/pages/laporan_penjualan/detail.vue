<style scoped>
  .title-pesanan {
    color :#050505;
    font-style:italic;
    font-size:unset;
    margin-bottom:10px;
  }
</style>

<template lang="html">
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="laporan_penjualan_detail" :breadcrumb="breadcrumb" />
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
              <p class="title-pesanan">Bukti Pembayaran : {{pesanan.bukti_pembayaran ? 'Lihat' : 'Pelanggan belum mengirimkan bukti pembayaran'}}</p>
            </div>
          </div>
					<div class="row">
            <div class="col-md-8">
              <sui-input placeholder="Search..." icon="search" v-model="search" loading v-if="searchLoading" />
              <sui-input placeholder="Search..." icon="search" v-model="search" v-else />
            </div>
            <div class="col-md-4">
              <sui-button basic content="Batalkan" icon="remove" negative/>
              <sui-button basic v-bind:content="pesanan.button_status" icon="check" positive/>
            </div>
          </div>
          <Loading v-if="loading"/>
          <sui-table striped v-else>
            <TableHeader :header="tableHeader" />
            <TableBody :data="dataDetail" labelEdit="Detail" edit="0" v-on:delete="handleDelete" v-if="dataDetail.length"/>
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

    export default {
        data: () => ({
          errors: [],
          breadcrumb: [{value: 'index',label:'Home'}, {value: 'laporan_penjualan',label:'Laporan Penjualan'}, {value: 'laporan_penjualan_detail',label:'Detail'}],
          tableHeader: ['ID','Produk','Jumlah','Harga Jual','Subtotal','Hapus'],
          loading: true,
          searchLoading: false,
          search: '',
          detailPesanans: {},
          dataDetail: [],
          message_table_kosong: 'Data Detail Kosong',
          pesanan: {},
        }),
        mounted(){
          const app = this
          app.findPesanan(app.$route.params.id)
        },
        components:{
          Header, Breadcrumb, TableHeader, TableBody, TableKosong, Loading
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
          handleDelete(id){
						const app = this
            axios.delete(`api/detail-pesanans/${id}`).then((resp) => {
              const { data } = resp
              app.pesanan.total = data.data
              app.alert("Berhasil menghapus data produk")
              app.getDetails()
            })
            .catch((err) => {
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
  };
</script>
