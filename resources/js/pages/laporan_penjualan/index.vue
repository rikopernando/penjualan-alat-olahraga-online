<template>
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="laporan_penjualan" :breadcrumb="breadcrumb" />
          <br />
          <br />
          <sui-input placeholder="Search..." icon="search" v-model="search" loading v-if="searchLoading" />
          <sui-input placeholder="Search..." icon="search" v-model="search" v-else />
          <Loading v-if="loading"/>
          <sui-table striped v-else>
            <TableHeader :header="tableHeader" />
            <TableBody :data="dataPesanans" labelEdit="Detail" edit="laporan_penjualan_detail" v-on:delete="handleDelete" v-if="dataPesanans.length"/>
            <TableKosong colspan="6" :text="message_table_kosong" v-else/>
          </sui-table>
					<pagination :data="pesanans" v-on:pagination-change-page="getPesanans" :limit="4"></pagination>
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
          breadcrumb: [{value: 'index',label:'Home'}, {value: 'laporan_penjualan',label:'Laporan Penjualan'}],
          tableHeader: ['ID Order','Pelanggan','Waktu','Total','Status','Detail','Hapus'],
          loading: true,
          search: '',
          searchLoading: '',
          pesanans: {},
          dataPesanans: [],
          message_table_kosong: 'Data Penjualan Kosong'
        }),
        components:{
          Header, Breadcrumb, TableHeader, TableBody, TableKosong, Loading
        },
        mounted(){
          const app = this
          app.getPesanans()
        },
        watch: {
          search(){
              const app = this
              app.searchLoading = true
              app.getPesanans()
          }
        },
        methods: {
          getPesanans(page = 1){
            const app = this
            axios.get(`api/pesanans?page=${page}&search=${app.search}`).then((resp) => {
              app.pesanans = resp.data
              app.dataPesanans = resp.data.data
              app.searchLoading = false
              app.loading = false
              if(!app.pesanans.data.length && app.search){ 
                app.message_table_kosong = `Oopps, Tidak ada data Penjualan yang ditemukan untuk kata kunci "${app.search}". Cobalah menggunakan kata kunci yang lain.`
              }
            })
            .catch((err) => {
              app.searchLoading = false
              app.loading = false
              alert("Gagal Memuat Data Penjualan")
              console.log(err)
            })
          },
          handleDelete(id){
						const app = this
            axios.delete(`api/pesanans/${id}`).then((resp) => {
              app.alert("Berhasil menghapus data penjualan")
              app.getPesanans()
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
