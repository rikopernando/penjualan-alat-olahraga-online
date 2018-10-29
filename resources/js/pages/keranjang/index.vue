<template>
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="keranjang" :breadcrumb="breadcrumb" />
          <br />
          <br />
					<div class="row">
            <div class="col-md-7">
              <sui-input placeholder="Search..." icon="search" v-model="search" loading v-if="searchLoading" />
              <sui-input placeholder="Search..." icon="search" v-model="search" v-else />
            </div>
            <div class="col-md-3">
              <sui-segment>
								<h5 is="sui-header" text-align="right">
                	Total : Rp {{this.$store.state.keranjang.total}}
								</h5>
              </sui-segment>
            </div>
            <div class="col-md-2">
              <router-link :to="{name: 'checkout'}" class="ui black icon right labeled button">
                <sui-icon name="right arrow" />
                Checkout
              </router-link>
            </div>
          </div>
          <Loading v-if="loading"/>
          <sui-table striped v-else>
            <TableHeader :header="tableHeader" />
            <TableBody :data="dataKeranjangs" labelEdit="Edit" edit="0" v-on:delete="handleDelete" v-if="dataKeranjangs.length"/>
            <TableKosong colspan="6" :text="message_table_kosong" v-else/>
          </sui-table>
					<pagination :data="keranjangs" v-on:pagination-change-page="getKeranjang" :limit="4"></pagination>
      </div>
      <Footer />
    </div>
</template>

<script>

    import Header from '../../components/Header'
    import Breadcrumb from '../../components/Breadcrumb'
    import TableHeader from '../../components/TableHeader'
    import TableBody from '../../components/TableBody'
    import TableKosong from '../../components/TableKosong'
    import Loading from '../../components/Loading'
    import Footer from '../../components/Footer'
    import { mapState } from 'vuex'

    export default {
        data: () => ({
          breadcrumb: [{value: 'index',label:'Home'}, {value: 'keranjang',label:'Keranjang'}],
          tableHeader: ['ID','Produk','Jumlah','Harga Jual','Subtotal','Hapus'],
          search: '',
        }),
        components:{
          Header, Breadcrumb, TableHeader, TableBody, TableKosong, Loading, Footer
        },
        computed: mapState({
          keranjangs(){
            const app = this
            return app.$store.state.keranjang.keranjang
          },
          dataKeranjangs(){
            const app = this
            return app.$store.state.keranjang.keranjang.data
          },
          loading(){
            const app = this
            return app.$store.state.keranjang.loading
          },
          searchLoading(){
            const app = this
            return app.$store.state.keranjang.searchLoading
          },
          message_table_kosong(){
            const app = this
            return app.$store.state.keranjang.message_table_kosong
          },
          profile(){
            const app = this
            return app.$store.state.user.profile
          }
        }),
        watch: {
          search(){
            const app = this
            app.getKeranjang()
          },
        },
        methods:{
          getKeranjang(page = 1){
            const app = this
            app.$store.dispatch('keranjang/LOAD_KERANJANG',{
              page: page,
              search: app.search,
              pelanggan: app.profile.id
            })
          },
          handleDelete(id){
						const app = this
            axios.delete(`api/keranjangs/${id}`).then((resp) => {
              app.$store.dispatch('keranjang/LOAD_KERANJANG',{
                page: 1,
                search: app.search,
                pelanggan: app.profile.id
              })
              app.alert("Berhasil menghapus data keranjang")
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
