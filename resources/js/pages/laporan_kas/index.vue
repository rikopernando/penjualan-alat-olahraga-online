<template>
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="laporan_kas" :breadcrumb="breadcrumb" />
          <br />
          <br />
          <div class="row">
            <div class="col-md-12" style="margin-left: 5px">
                <form class="ui form">
                  <div class="four fields">
                    <Datepicker style="margin-right: 10px;" placeholder="Dari Tanggal" v-model="dari_tanggal"></Datepicker>
                    <Datepicker style="margin-right: 10px;" placeholder="Sampai Tanggal" v-model="sampai_tanggal"></Datepicker>
                    <SelectInput
                      label=""
                      :options="bank"
                      :placeholder="{placeholder: 'Pilih Bank'}"
                      v-model="bankId"
                      :loading="false"
                    />
                    <sui-button type="button" color="black" content="Filter" v-on:click="saveForm()"/>
                    <sui-button type="button" color="black" content="Cetak" v-on:click="cetak()"/>
                  </div>
                </form>
            </div>
          </div>
          <Loading v-if="loading"/>
          <sui-table striped v-else>
            <TableHeader :header="tableHeader" />
            <TableBody :data="dataPesanans" labelEdit="" edit="" hapus="0" v-on:delete="handleDelete" v-if="dataPesanans.length"/>
            <TableKosong colspan="6" :text="message_table_kosong" v-else/>
          </sui-table>
					<pagination :data="pesanans" v-on:pagination-change-page="saveForm" :limit="4" v-if="dari_tanggal && sampai_tanggal"></pagination>
					<pagination :data="pesanans" v-on:pagination-change-page="getPesanans" :limit="4" v-else></pagination>
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
    import SelectInput from '../../components/SelectInput'
    import Datepicker from 'vuejs-datepicker'


    export default {
        data: () => ({
          breadcrumb: [{value: 'index',label:'Home'}, {value: 'laporan_kas',label:'Laporan Kas'}],
          tableHeader: ['ID Order','Pelanggan','Waktu','Total','Status'],
          loading: true,
          search: '',
          searchLoading: '',
          pesanans: {},
          dataPesanans: [],
          message_table_kosong: 'Data Penjualan Kosong',
          dari_tanggal: '',
          sampai_tanggal: '',
          bank: [],
          bankId: ''
        }),
        components:{
          Header, Breadcrumb, TableHeader, TableBody, TableKosong, Loading, TextInput, Datepicker, SelectInput
        },
        mounted(){
          const app = this
          app.loadBank()
          app.loading = false
        },
        watch: {
          search(){
              const app = this
              app.searchLoading = true
              app.dari_tanggal && app.sampai_tanggal 
                ? app.saveForm()
                : app.getPesanans()
          }
        },
        methods: {
          loadBank(){
            const app = this
            axios.get('api/banks/all').then((resp) => {
              app.bank = resp.data
            })
            .catch((err) => {
              console.log(err)
              alert("Gagal memuat Bank")
            })
          },
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
              app.alert("Berhasil menghapus data penjualan","success",1000)
              app.getPesanans()
            })
            .catch((err) => {
              alert(err)
              console.log(err)
            })
          },
          saveForm(page = 1){
            const app = this
            if(app.validate()){
                const data = { 
                    dari_tanggal: app.dateFormat(app.dari_tanggal),
                    sampai_tanggal: app.dateFormat(app.sampai_tanggal),
                    bank: app.bankId
                }
                if(!app.search) app.loading = true
                axios.post(`api/pesanans/filter?page=${page}&search=${app.search}`,data)
                .then((resp) => {
                  console.log(resp.data.data)
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
                })
            }
          },
          cetak(){
            const app = this
            if(app.validate()){
                const dari_tanggal = app.dateFormat(app.dari_tanggal)
                const sampai_tanggal = app.dateFormat(app.sampai_tanggal)
                const bank = app.bankId
                window.open(`pesanans-cetak-penjualan?dari_tanggal=${dari_tanggal}&sampai_tanggal=${sampai_tanggal}&bank=${bank}`,'_blank');
            }
          },
          validate(){
            const app = this
            if(!app.dari_tanggal){
              app.alert("Dari Tanggal harus disi","error",5000) 
              return false
            }else if(!app.sampai_tanggal){
              app.alert("Sampai Tanggal harus disi","error",5000) 
              return false
            }else if(!app.bankId){
              app.alert("Bank harus dipilih","error",5000) 
              return false
            }
            return true
          },
          dateFormat(tanggal){
            const newtanggal = "" + tanggal.getFullYear() +'-'+ ((tanggal.getMonth() + 1) > 9 ? '' : '0') + (tanggal.getMonth() + 1) +'-'+ (tanggal.getDate() > 9 ? '' : '0') + tanggal.getDate()
            return newtanggal
          },
          alert(pesan,icon,timer){
						const app = this
						app.$swal({
							text: pesan,
							icon: icon,
							buttons: false,
							timer: 1000,
						})
          }
        }
    };
</script>