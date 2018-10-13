<template>
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="user" :breadcrumb="breadcrumb" />
          <br />
          <br />
          <router-link :to="{name: 'user_create'}" class="ui primary button">Tambah</router-link>
          <sui-input placeholder="Search..." icon="search" v-model="search" loading v-if="searchLoading" />
          <sui-input placeholder="Search..." icon="search" v-model="search" v-else />
          <Loading v-if="loading"/>
          <sui-table striped v-else>
            <TableHeader :header="tableHeader" />
            <TableBody :data="users.data" edit="/create" v-on:delete="handleDelete" v-if="users.data.length"/>
            <TableKosong colspan="6" :text="message_table_kosong" v-else/>
          </sui-table>
					<pagination :data="users" v-on:pagination-change-page="getUser" :limit="4"></pagination>
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
          breadcrumb: [{value: 'dashboard',label:'Dashboard'}, {value: 'user',label:'Users'}],
          tableHeader: ['ID','Name','E-mail','Otoritas','Edit','Hapus'],
          loading: true,
          users:{},
          searchLoading: false,
          search: '',
          message_table_kosong: 'Data Users Kosong'
        }),
        components:{
          Header, Breadcrumb, TableHeader, TableBody, TableKosong, Loading
        },
        mounted(){
          const app = this
          app.getUser()
        },
        watch: {
          search(){
            const app = this
            app.searchLoading = true
            app.getUser()
          }
        },
        methods:{
          getUser(page = 1){
            const app =  this
            axios.get(`api/users?page=${page}&search=${app.search}`).then((resp) => {
              app.users = resp.data
              app.searchLoading = false
              app.loading = false
              if(!app.users.data.length && app.search){ 
                app.message_table_kosong = `Oopps, Tidak ada data User yang ditemukan untuk kata kunci "${app.search}". Cobalah menggunakan kata kunci yang lain.`
              }
                
            })
            .catch((err) => {
              app.searchLoading = false
              app.loading = false
              alert("Gagal Memuat Data User")
              console.log(err)
            })
          },
          handleDelete(id){
						const app = this
            axios.delete(`api/users/${id}`).then((resp) => {
              app.alert("Berhasil menghapus data user")
              app.getUser()
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
