<template lang="html">
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="bank_edit" :breadcrumb="breadcrumb" />
          <br />
          <br />
          <form v-on:submit.prevent="saveForm()" v-bind:class="[loading ? 'ui loading form' : 'ui form']">
            <TextInput 
              label="Name"
              type="text"
              id="name"
              placeholder="Name"
              v-model="banks.name"
              :errors="errors.name"
            />
            <TextInput 
              label="Atas Nama"
              type="text"
              id="atas_nama"
              placeholder="Atas Nama"
              v-model="banks.atas_nama"
              :errors="errors.atas_nama"
            />
            <TextInput 
              label="No. Rekening"
              type="text"
              id="no_rek"
              placeholder="No. Rekening"
              v-model="banks.no_rek"
              :errors="errors.no_rek"
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

    export default {
        data: () => ({
          breadcrumb: [{value: 'index',label:'Home'}, {value: 'bank',label:'Bank'}, {value: 'bank_edit',label:'Edit Bank'}],
          loading: false,
          errors: [],
          message: '',
          banks: {
            name: '',
            atas_nama: '',
            no_rek: '',
          },
       }),
        mounted(){
          const app = this
          app.findBank(app.$route.params.id)
        },
        components:{
          Header, Breadcrumb, TextInput
        },
        methods: {
          findBank(id){
            const app = this
            axios.get(`api/banks/${id}`).then((resp) => {
              const { data } = resp
              app.banks.name = data.name
              app.banks.no_rek = data.no_rek
              app.banks.atas_nama = data.atas_nama
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
            axios.put(`api/banks/${id}`,app.banks).then((resp) => {
              app.loading = false
              app.alert("Berhasil Mengubah Bank")
              app.$router.push('/bank')
            })
            .catch((err) => {
              console.log(err)
              const app = this
              const errors = err.response.data
              app.loading = false
              app.setError(errors)
            })
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
