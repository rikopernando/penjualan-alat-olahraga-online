<template>
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="bank" :breadcrumb="breadcrumb" />
          <br />
          <br />
          <router-link :to="{name: 'bank_create'}" class="ui primary button">Tambah</router-link>
          <sui-input placeholder="Search..." icon="search" v-model="search" loading v-if="searchLoading" />
          <sui-input placeholder="Search..." icon="search" v-model="search" v-else />
          <Loading v-if="loading"/>
          <sui-table striped v-else>
            <TableHeader :header="tableHeader" />
            <TableBody :data="dataBanks" labelEdit="Edit" edit="bank_edit" v-on:delete="handleDelete" v-if="dataBanks.length"/>
            <TableKosong colspan="6" :text="message_table_kosong" v-else/>
          </sui-table>
					<pagination :data="banks" v-on:pagination-change-page="getBank" :limit="4"></pagination>
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
          breadcrumb: [{value: 'index',label:'Home'}, {value: 'bank',label:'Bank'}],
          tableHeader: ['ID','Nama','Atas Nama','No. Rekening','Default','Edit','Hapus'],
          loading: true,
          banks: {},
          dataBanks: [],
          searchLoading: false,
          search: '',
          message_table_kosong: 'Data Banks Kosong'
        }),
        components:{
          Header, Breadcrumb, TableHeader, TableBody, TableKosong, Loading
        },
        mounted(){
          const app = this
          app.getBank()
        },
        watch: {
          search(){
            const app = this
            app.searchLoading = true
            app.getBank()
          }
        },
        methods:{
          getBank(page = 1){
            const app =  this
            axios.get(`api/banks?page=${page}&search=${app.search}`).then((resp) => {
              app.banks = resp.data
              app.dataBanks = resp.data.data
              app.searchLoading = false
              app.loading = false
              if(!app.banks.data.length && app.search){ 
                app.message_table_kosong = `Oopps, Tidak ada data Bank yang ditemukan untuk kata kunci "${app.search}". Cobalah menggunakan kata kunci yang lain.`
              }
                
            })
            .catch((err) => {
              app.searchLoading = false
              app.loading = false
              alert("Gagal Memuat Data Bank")
              console.log(err)
            })
          },
          handleDelete(id){
						const app = this
            axios.delete(`api/banks/${id}`).then((resp) => {
              app.alert("Berhasil menghapus data bank")
              app.getBank()
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
