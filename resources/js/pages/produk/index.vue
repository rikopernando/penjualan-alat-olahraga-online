<template>
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="produk" :breadcrumb="breadcrumb" />
          <br />
          <br />
          <router-link :to="{name: 'produk_create'}" class="ui primary button">Tambah</router-link>
          <sui-input placeholder="Search..." icon="search" v-model="search" loading v-if="searchLoading" />
          <sui-input placeholder="Search..." icon="search" v-model="search" v-else />
          <Loading v-if="loading"/>
          <sui-table striped v-else>
            <TableHeader :header="tableHeader" />
            <TableBody :data="dataProduks" labelEdit="Edit" edit="produk_edit" v-on:delete="handleDelete" v-if="dataProduks.length"/>
            <TableKosong colspan="6" :text="message_table_kosong" v-else/>
          </sui-table>
					<pagination :data="produks" v-on:pagination-change-page="getProduk" :limit="4"></pagination>
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
          breadcrumb: [{value: 'index',label:'Home'}, {value: 'produk',label:'Produk'}],
          tableHeader: ['ID','Nama Produk','Harga Jual','Deskripsi','Edit','Hapus'],
          loading: true,
          produks: {},
          dataProduks: [],
          searchLoading: false,
          search: '',
          message_table_kosong: 'Data Produk Kosong'
        }),
        components:{
          Header, Breadcrumb, TableHeader, TableBody, TableKosong, Loading
        },
        mounted(){
          const app = this
          app.getProduk()
        },
        watch: {
          search(){
            const app = this
            app.searchLoading = true
            app.getProduk()
          }
        },
        methods:{
          getProduk(page = 1){
            const app = this
            axios.get(`api/produks?page=${page}&search=${app.search}`).then((resp) => {
              app.produks = resp.data
              app.dataProduks = resp.data.data
              app.searchLoading = false
              app.loading = false
              if(!app.produks.data.length && app.search){ 
                app.message_table_kosong = `Oopps, Tidak ada data Produk yang ditemukan untuk kata kunci "${app.search}". Cobalah menggunakan kata kunci yang lain.`
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
            axios.delete(`api/produks/${id}`).then((resp) => {
              app.alert("Berhasil menghapus data produk")
              app.getProduk()
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
