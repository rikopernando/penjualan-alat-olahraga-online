<template lang="html">
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="user_create" :breadcrumb="breadcrumb" />
          <br />
          <br />
          <form v-on:submit.prevent="saveForm()" v-bind:class="[loading ? 'ui loading form' : 'ui form']">
          <Message :header="message" :errors="errors" v-if="errors.length" />
            <TextInput 
              label="Name"
              type="text"
              id="name"
              placeholder="Name"
              v-model="users.name"
            />
            <TextInput 
              label="Password"
              type="password"
              id="password"
              placeholder="Password"
              v-model="users.password"
            />
            <TextInput 
              label="E-mail"
              type="email"
              id="email"
              placeholder="E-mail"
              v-model="users.email"
            />
						<sui-form-field>
							<label>Otoritas</label>
								<selectize-component :settings="placeholder_otoritas" v-model="users.otoritas" ref="otoritas">
                    <option v-for="otoritas, index in this.$store.state.otoritas.otoritas" v-bind:value="otoritas.id">
                        {{ otoritas.display_name }}
                    </option> 
								</selectize-component>
						</sui-form-field>
            <sui-button type="submit" color="black" content="Submit"/>
          </form>
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
          breadcrumb: [{value: 'index',label:'Home'}, {value: 'user',label:'Users'}, {value: 'user_create',label:'Tambah User'}],
          loading: false,
          errors: [],
          message: '',
          users: {
            name: '',
            password: '',
            email: '',
            otoritas: ''
          },
					placeholder_otoritas: {
						placeholder : 'Otoritas'
					}
        }),
        mounted(){
          const app = this
          app.$store.dispatch('otoritas/LOAD_OTORITAS')
        },
        components:{
          Header, Breadcrumb, TextInput, Message, Loading
        },
        methods: {
          saveForm(){
            const app = this
            app.loading = true
            axios.post('api/users',app.users).then((resp) => {
              app.loading = false
              app.alert("Berhasil Menambahkan Users baru")
              app.$router.push('/user')
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
