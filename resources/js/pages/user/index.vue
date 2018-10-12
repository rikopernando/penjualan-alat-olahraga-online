<template>
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="user" :breadcrumb="breadcrumb" />
          <br />
          <br />
          <router-link :to="{name: 'user_create'}" class="ui primary button">Tambah</router-link>
          <Loading v-if="loading"/>
          <sui-table striped v-else>
            <TableHeader :header="tableHeader" />
            <TableBody :data="users.data" v-if="Object.keys(users).length"/>
            <TableKosong colspan="4" text="Data User Kosong" v-else/>
          </sui-table>
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
          tableHeader: ['ID','Name','E-mail','Otoritas'],
          loading: true,
          users:{}
        }),
        components:{
          Header, Breadcrumb, TableHeader, TableBody, TableKosong, Loading
        },
        mounted(){
          const app = this
          app.getUser()
        },
        methods:{
          getUser(){
            const app =  this
            axios.get('api/users').then((resp) => {
              app.users = resp.data
              app.loading = false
            })
            .catch((err) => {
              app.loading = false
              alert("Gagal Memuat Data User")
              console.log(err)
            })
          }
        }
    };
</script>
