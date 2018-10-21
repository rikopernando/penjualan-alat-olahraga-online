<template> 
  <div>
    <Header />
      <div class="container" style="margin-top: 70px;">
		   <Breadcrumb active="checkout" :breadcrumb="breadcrumb" />
        <br />
        <br />
        <form v-on:submit.prevent="saveForm()" id="form-error" v-bind:class="[loading ? 'ui loading form' : 'ui form']">
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
            <TextInput 
              label="Catatan"
              type="textarea"
              id="catatan"
              placeholder="Catatan"
              v-model="pesanans.catatan"
              :errors="errors.catatan"
            />
          <sui-button type="submit" color="black" content="Submit"/>
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
      loading: false,
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
        kelurahan: '',
        catatan: ''
      }
    }),
    mounted(){
      const app = this
      app.setProfile()
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
       profile() {
        return this.$store.state.user.profile
       },
       total() {
        return this.$store.state.keranjang.total
       }
    }),
    watch: {
      'pesanans.kabupaten': function(){
         const app = this
         app.loadWilayah("kecamatan",app.pesanans.kabupaten)
      },
      'pesanans.kecamatan': function(){
         const app = this
         app.loadWilayah("kelurahan",app.pesanans.kecamatan)
      },
      total: function(){
         const app = this
         app.pesanans.total = app.total
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
      },
      setProfile(){
        const app = this
        const { name, email, alamat, no_telp, provinsi, kabupaten, kecamatan, kelurahan } = app.profile
        app.pesanans.nama = name
        app.pesanans.alamat = alamat
        app.pesanans.email = email
        app.pesanans.no_telp = no_telp
        app.pesanans.provinsi = provinsi
        app.pesanans.kabupaten = kabupaten
        app.pesanans.kecamatan = kecamatan
        app.pesanans.kelurahan = kelurahan
      },
      saveForm(){
        const app = this
        app.loading = true
        axios.post('api/pesanans',app.pesanans).then((resp) => {
          app.loading = false
          const { data } = resp
          const { status, message } = data
          if(status == 3){
              app.alert("Pesanan Berhasil","success",1000)
              app.$router.push('/')
          }else{
              app.alert(message,"error",3000)
          }
        })
        .catch((err) => {
          console.log(err)
          const app = this
          const errors = err.response.data
          app.loading = false
          app.setError(errors)
          document.getElementById("form-error").focus({reventScroll:true})
        })
      },
      setError(errors){
        const app = this
        if(Object.keys(errors).length) {
          app.errors = errors.errors
        }
      },
      alert(pesan,icon,timer){
        const app = this
        app.$swal({
          text: pesan,
          icon: icon,
          buttons: false,
          timer: timer,
        })
      }
    }
}
</script>
