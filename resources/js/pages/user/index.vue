<template>
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="user" :breadcrumb="breadcrumb" />
          <sui-table striped>
            <sui-table-header>
              <sui-table-row>
                <sui-table-header-cell>Name</sui-table-header-cell>
                <sui-table-header-cell>Date Joined</sui-table-header-cell>
                <sui-table-header-cell>E-mail</sui-table-header-cell>
                <sui-table-header-cell>Called</sui-table-header-cell>
              </sui-table-row>
            </sui-table-header>
            <sui-table-body>
              <sui-table-row>
                <sui-table-cell>John Lilki</sui-table-cell>
                <sui-table-cell>September 14, 2013</sui-table-cell>
                <sui-table-cell>jhlilk22@yahoo.com</sui-table-cell>
                <sui-table-cell>No</sui-table-cell>
              </sui-table-row>
            </sui-table-body>
          </sui-table>
      </div>
    </div>
</template>

<script>
    import Header from '../../components/Header'
    import Breadcrumb from '../../components/Breadcrumb'

    export default {
        data: () => ({
          breadcrumb: [{value: 'dashboard',label:'Dashboard'}, {value: 'user',label:'Users'}]
        }),
        components:{
          Header, Breadcrumb
        },
        mounted(){
          const app = this
          app.getUser()
        },
        methods:{
          getUser(){
            axios.get('api/user').then((resp) => {
              console.log(resp)
            })
            .catch((err) => {
              console.log(err)
            })
          }
        }
    };
</script>
