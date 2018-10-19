<template> 
  <div>
    <Header />
      <div class="container" style="margin-top: 70px;">
		   <Breadcrumb active="checkout" :breadcrumb="breadcrumb" />
        <br />
        <br />
        <form class="ui form">
          <h4 class="ui dividing header">Pengiriman</h4>
            <TextInput 
              label="Nama"
              type="text"
              id="nama"
              placeholder="Nama"
              v-model="pesanans.nama"
              :errors="errors.nama"
            />
            <div class="two fields">
              <TextInput 
                label="No. Telepon"
                type="text"
                id="no_telp"
                placeholder="No. Telepon"
                v-model="pesanans.no_telp"
                :errors="errors.no_telp"
              />
              <TextInput 
                label="Email"
                type="email"
                id="email"
                placeholder="Email"
                v-model="pesanans.email"
                :errors="errors.email"
              />
            </div>
            <TextInput 
              label="Alamat Pengiriman"
              type="text"
              id="alamat"
              placeholder="Alamat Pengiriman"
              v-model="pesanans.alamat"
              :errors="errors.alamat"
            />
            <div class="two fields">
              <SelectInput
                label="Kabupaten / Kota"
                :options="kabupaten"
                :placeholder="{placeholder: 'Cari Kabupaten / Kota'}"
                v-model="pesanans.kabupaten"
                :errors="errors.kabupaten"
								:loading="this.$store.state.lokasi.load_kabupaten"
              />
              <SelectInput
                label="Kecamatan"
                :options="kecamatan"
                :placeholder="{placeholder: 'Cari Kecamatan'}"
                v-model="pesanans.kecamatan"
                :errors="errors.kecamatan"
								:loading="this.$store.state.lokasi.load_kecamatan"
              />
              <SelectInput
                label="Kelurahan"
                :options="kelurahan"
                :placeholder="{placeholder: 'Cari Kelurahan'}"
                v-model="pesanans.kelurahan"
                :errors="errors.kelurahan"
								:loading="this.$store.state.lokasi.load_kelurahan"
              />
            </div>
          <div class="ui button" tabindex="0">Submit Order</div>
        </form>
      </div>
  </div>
</template>

<script>

  import Header from '../../components/Header'
  import Breadcrumb from '../../components/Breadcrumb'
  import TextInput from '../../components/TextInput'
  import SelectInput from '../../components/SelectInput'
  import { mapState } from 'vuex'

  
  export default {
    data: () => ({
      breadcrumb: [{value: 'index',label:'Home'}, {value: 'keranjang',label:'Keranjang'}, {value: 'checkout',label:'Checkout'}],
      errors: [],
      pesanans: {
        nama: '',
        alamat : '',
        email: '',
        no_telp: '',
        total : 0,
        provinsi: '',
        kabupaten: '',
        kecamatan: '',
        kelurahan: ''
      }
    }),
    mounted(){
      const app = this
			app.$store.dispatch('lokasi/LOAD_WILAYAH',{
				type : "kabupaten",
				id : 18,
			}) 
    },
    computed : mapState ({
       kabupaten() {
        return this.$store.state.lokasi.kabupaten
       },
       kecamatan() {
        return this.$store.state.lokasi.kecamatan
       },
       kelurahan() {
        return this.$store.state.lokasi.kelurahan
       },
    }),
    watch: {
      'pesanans.kabupaten': function(){
         const app = this
         app.loadWilayah("kecamatan",app.pesanans.kabupaten)
      },
      'pesanans.kecamatan': function(){
         const app = this
         app.loadWilayah("kelurahan",app.pesanans.kecamatan)
      }
    },
    components : {
      Header, Breadcrumb, TextInput, SelectInput
    },
    methods: {
      loadWilayah(type,id){
         const app = this
         app.$store.dispatch('lokasi/LOAD_WILAYAH',{
           type : type,
           id : id,
        }) 
      }
    }
}
</script>
