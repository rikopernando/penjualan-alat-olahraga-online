<template lang="html">
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="user_create" :breadcrumb="breadcrumb" />
          <br />
          <br />
          <sui-form v-on:submit.prevent="saveForm()">
          <Message :header="message" :errors="errors" v-if="errors.length" />
            <TextInput 
              label="Name"
              type="text"
              placeholder="Name"
              v-model="users.name"
            />
            <TextInput 
              label="Password"
              type="password"
              placeholder="Password"
              v-model="users.password"
            />
            <TextInput 
              label="E-mail"
              type="email"
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
            <sui-button type="submit" color="black" content="Submit" />
          </sui-form>
      </div>
    </div>
</template>

<script>

    import Header from '../../components/Header'
    import Breadcrumb from '../../components/Breadcrumb'
    import TextInput from '../../components/TextInput'
    import Message from '../../components/Message'

    export default {
        data: () => ({
          errors: [],
          message: '',
          breadcrumb: [{value: 'dashboard',label:'Dashboard'}, {value: 'user',label:'Users'}, {value: 'user_create',label:'Tambah User'}],
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
          Header, Breadcrumb, TextInput, Message
        },
        methods: {
          saveForm(){
            const app = this
            axios.post('api/users',app.users).then((resp) => {
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
          }
        }
  };
</script>
