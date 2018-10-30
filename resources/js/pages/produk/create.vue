<template lang="html">
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="produk_create" :breadcrumb="breadcrumb" />
          <br />
          <br />
          <form v-on:submit.prevent="saveForm()" id="form-error" v-bind:class="[loading ? 'ui loading form' : 'ui form']">
            <TextInput 
              label="Nama Produk"
              type="text"
              id="nama"
              placeholder="Nama Produk"
              v-model="produks.nama"
              :errors="errors.nama"
            />
            <TextInput 
              label="Harga Jual"
              type="number"
              id="harga_jual"
              placeholder="Harga Jual"
              v-model="produks.harga_jual"
              :errors="errors.harga_jual"
            />
            <TextInput 
              label="Stok Produk"
              type="number"
              id="stok"
              placeholder="Stok Produk"
              v-model="produks.stok"
              :errors="errors.stok"
            />
            <SelectInput
              label="Warna"
              :options="warna"
              :placeholder="{
                placeholder: 'Pilih Warna',
								delimiter: ',',
								maxItems: null,
              }"
              v-model="produks.warna"
              :errors="errors.warna"
              :loading="false"
            />
            <TextInput 
              label="Deskripsi Produk"
              type="textarea"
              id="deskripsi"
              placeholder="Deskripsi Produk"
              v-model="produks.deskripsi"
              :errors="errors.deskripsi"
            />
            <TextInput 
              label="Foto"
              type="file"
              id="foto"
              placeholder="Foto"
              v-model="produks.foto"
              :errors="errors.foto"
            />
            <p style="color :red; font-style:italic;">* Ukuran foto yang disarankan 236 x 255</p>
            <sui-image :src="previewFoto" size="medium" v-if="previewFoto" />
            <br />
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

    export default {
        data: () => ({
          breadcrumb: [{value: 'index',label:'Home'}, {value: 'produk',label:'Produk'}, {value: 'produk_create',label:'Tambah Produk'}],
          loading: false,
          errors: [],
          message: '',
          warna: [
            {
              id: 'Biru',
              name: 'Biru'
            },
            {
              id: 'Hijau',
              name: 'Hijau'
            },
            {
              id: 'Hitam',
              name: 'Hitam'
            },
            {
              id: 'Kuning',
              name: 'Kuning'
            },
            {
              id: 'Merah',
              name: 'Merah'
            },
            {
              id: 'Putih',
              name: 'Putih'
            },
          ],
          produks: {
            nama: '',
            harga_jual: '',
            foto: '',
            deskripsi: '',
            warna: '',
            stok: '',
          },
          previewFoto: ''
        }),
        watch: {
          'produks.foto':function(){
             const app = this
             app.createImage()
          }
        },
        components:{
          Header, Breadcrumb, TextInput, SelectInput
        },
        methods: {
          createImage(){
            const app = this
            const file = document.getElementById('foto').files[0]
            const image = new Image()
            const reader = new FileReader()

            reader.onload = (e) => {
              app.previewFoto = e.target.result
            }

            reader.readAsDataURL(file)
          },
          saveForm(){
            const app = this
            app.loading = true
            axios.post('api/produks',app.inputData()).then((resp) => {
              app.loading = false
              app.alert("Berhasil Menambahkan Produk baru")
              app.$router.push('/produk')
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
          inputData(){
            const { nama, harga_jual, deskripsi, stok, warna } = this.produks
            const data = new FormData()
						if (document.getElementById('foto').files[0] != undefined) {
						 data.append('foto', document.getElementById('foto').files[0]);
					 	}
						data.append('nama',nama)
						data.append('harga_jual',harga_jual)
						data.append('deskripsi',deskripsi)
						data.append('stok',stok)
						data.append('warna',warna)

            return data
          },
          setError(errors){
            const app = this
            if(Object.keys(errors).length) {
              app.errors = errors.errors
            }
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
