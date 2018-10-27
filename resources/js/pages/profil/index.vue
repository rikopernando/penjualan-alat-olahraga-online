<template>
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="profil" :breadcrumb="breadcrumb" />
          <h4 class="ui dividing header">{{profile.name}}</h4>
					<sui-grid>
						<sui-grid-column :width="3">
							<sui-menu fluid vertical tabular>
								<a
									v-for="item in items"
									:key="item"
									is="sui-menu-item"
									:content="item"
									:active="isActive(item)"
									@click="select(item)"
								/>
							</sui-menu>
						</sui-grid-column>

						<sui-grid-column stretched :width="13">
							<sui-segment>
                <DashboardProfil v-if="active == 'Dashboard'" 
                  :name="profile.name"
                  :no_telp="profile.no_telp"
                  :alamat="profile.alamat"
                  :email="profile.email"
                />
                <div v-else-if="active == 'Pesanan Saya'">
                  <sui-input placeholder="Search..." icon="search" v-model="search" loading v-if="searchLoading" />
                  <sui-input placeholder="Search..." icon="search" v-model="search" v-else />
                  <Loading v-if="loading"/>
                  <sui-table striped v-else>
                    <TableHeader :header="tableHeader" />
                    <TableBody
                      :data="dataPesanans" 
                      labelEdit="Detail" 
                      edit="detail_pesanan_saya" 
                      hapus="0"
                      v-if="dataPesanans.length"
                    />
                    <TableKosong colspan="6" :text="message_table_kosong" v-else/>
                  </sui-table>
                  <pagination :data="pesanans" v-on:pagination-change-page="getPesanan" :limit="4"></pagination>
                </div>
							</sui-segment>
						</sui-grid-column>
					</sui-grid>
        </div>
    </div>
</template>

<script>

  import Header from '../../components/Header'
  import Breadcrumb from '../../components/Breadcrumb'
  import DashboardProfil from '../../components/DashboardProfil'
  import TableHeader from '../../components/TableHeader'
  import TableBody from '../../components/TableBody'
  import TableKosong from '../../components/TableKosong'
  import Loading from '../../components/Loading'
  import { mapState } from 'vuex'

  export default {
    data: () => ({
      breadcrumb: [{value: 'index',label:'Home'}, {value: 'profil',label:'Profil'}],
      items: ['Dashboard','Pesanan Saya'],
      active: 'Dashboard',
      tableHeader: ['ID Order','Pelanggan','Waktu','Total','Status','Detail'],
      loading: true,
      search: '',
      searchLoading: '',
      pesanans: {},
      dataPesanans: [],
      message_table_kosong: 'Pesanan Anda Kosong'
    }),
    components:{
      Header, Breadcrumb, DashboardProfil, TableHeader, TableBody, TableKosong, Loading
    },
    computed : mapState ({
       profile() {
        return this.$store.state.user.profile
       },
    }),
    watch: {
      search(){
          const app = this
          app.searchLoading = true
          app.getPesanan()
      }
    },
		methods: {
			isActive(name) {
				return this.active === name;
			},
			select(name) {
        const app = this
				app.active = name;
        name == 'Pesanan Saya' && app.getPesanan() 
			},
      getPesanan(page = 1){
        const app = this
        axios.get(`api/pesanan-saya?page=${page}&search=${app.search}`).then((resp) => {
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
      alert(pesan){
        const app = this
        app.$swal({
          text: pesan,
          icon: "success",
          buttons: false,
          timer: 1000,
        })
      }
		},
  }
</script>
