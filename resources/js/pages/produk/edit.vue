<template lang="html">
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="produk_edit" :breadcrumb="breadcrumb" />
          <br />
          <br />
          <Loading v-if="loading" />
          <sui-form v-on:submit.prevent="saveForm()" id="form-error">
          <Message :header="message" :errors="errors" v-if="errors.length" />
            <TextInput 
              label="Nama Produk"
              type="text"
              id="nama"
              placeholder="Nama Produk"
              v-model="produks.nama"
            />
            <TextInput 
              label="Harga Jual"
              type="number"
              id="harga_jual"
              placeholder="Harga Jual"
              v-model="produks.harga_jual"
            />
            <TextInput 
              label="Deskripsi Produk"
              type="textarea"
              id="deskripsi"
              placeholder="Deskripsi Produk"
              v-model="produks.deskripsi"
            />
            <TextInput 
              label="Foto"
              type="file"
              id="foto"
              placeholder="Foto"
              v-model="produks.foto"
            />
            <p style="color :red; font-style:italic;">* Ukuran foto yang disarankan 236 x 255</p>
            <sui-image :src="previewFoto" size="medium" v-if="previewFoto" />
            <br />
            <sui-button type="submit" color="black" content="Submit" v-if="!loading" />
          </sui-form>
      </div>
    </div>
</template>

<script>

    import Header from '../../components/Header'
    import Breadcrumb from '../../components/Breadcrumb'
    import TextInput from '../../components/TextInput'
    import Message from '../../components/Message'
    import Loading from '../../components/Loading'

    export default {
        data: () => ({
          breadcrumb: [{value: 'index',label:'Home'}, {value: 'produk',label:'Produk'}, {value: 'produk_edit',label:'Edit Produk'}],
          loading: false,
          errors: [],
          message: '',
          produks: {
            nama: '',
            harga_jual: '',
            foto: '',
            deskripsi: '',
          },
          previewFoto: ''
        }),
        mounted(){
          const app = this
          app.findProduk(app.$route.params.id)
        },
        watch: {
          'produks.foto':function(){
             const app = this
             app.createImage()
          }
        },
        components:{
          Header, Breadcrumb, TextInput, Message, Loading
        },
        methods: {
          createImage(){
            const app = this
            const file = document.getElementById('foto').files[0]
            if(file != undefined){
                const image = new Image()
                const reader = new FileReader()
                reader.onload = (e) => {
                  app.previewFoto = e.target.result
                }

                reader.readAsDataURL(file)
            }
          },
          findProduk(id){
            const app = this
            axios.get(`api/produks/${id}`).then((resp) => {
              const { data } = resp
              app.produks.nama = data.nama
              app.produks.harga_jual = data.harga_jual
              app.produks.deskripsi = data.deskripsi
              /*app.produks.foto = data.previewFoto*/
              app.previewFoto = data.previewFoto
            })
            .catch((err) => {
              console.log(err)
              alert(err)
            })
          },
          saveForm(){
            const app = this
            const id = app.$route.params.id
            app.loading = true
            console.log(app.inputData())
            axios.post(`api/produks/${id}`,app.inputData()).then((resp) => {
              app.loading = false
              app.alert("Berhasil Mengubah Produk")
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
            const { nama, harga_jual, deskripsi } = this.produks
            const data = new FormData()
						if (document.getElementById('foto').files[0] != undefined) {
						 data.append('foto', document.getElementById('foto').files[0]);
					 	}
						data.append('nama',nama)
						data.append('harga_jual',harga_jual)
						data.append('deskripsi',deskripsi)

            return data
          },
          setError(errors){
            const app = this
            if(Object.keys(errors).length) {
              let data = []
              app.message = errors.message
              Object.keys(errors.errors).forEach((error) => {
                 data.push(errors.errors[error][0])
              })
              app.errors = data
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
