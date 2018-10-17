<template lang="html">
  <div class="background">
    <sui-grid centered vertical-align="middle">
      <sui-grid-column>

        <h2 is="sui-header" color="teal" image>
          <sui-header-content>Register</sui-header-content>
        </h2>

        <sui-form v-on:submit.prevent="saveForm()">
          <Message :header="message" :errors="errors" v-if="errors.length" />
          <sui-segment stacked>
            <sui-form-field>
              <sui-input
              v-model="register.name"
              type="text"
              placeholder="Name"
              icon="user"
              icon-position="left" />
            </sui-form-field>
            <sui-form-field>
              <sui-input
              v-model="register.email"
              type="email"
              placeholder="E-mail address"
              icon="user"
              icon-position="left" />
            </sui-form-field>
            <sui-form-field>
              <sui-input
              v-model="register.password"
              type="password"
              placeholder="Password"
              icon="lock"
              icon-position="left" />
            </sui-form-field>
            <sui-form-field>
              <sui-input
              v-model="register.password_confirmation"
              type="password"
              placeholder="Password Confirmation"
              icon="lock"
              icon-position="left" />
            </sui-form-field>
            <Loading v-if="loading" />
            <sui-button size="large" color="teal" fluid v-else>Register</sui-button>
          </sui-segment>
        </sui-form>

        <sui-message>Sudah punya akun? <router-link :to="{name: 'login'}">Login</router-link></sui-message>
      </sui-grid-column>
    </sui-grid>
  </div>
</template>

<script>

import Message from '../components/Message'
import Loading from '../components/Loading'

export default {
  data: () => ({
    loading: false,
    errors: [],
    message: '',
    register: {
        email: '',
        password: '',
        name: '',
        password_confirmation: ''
    }
  }),
  components:{
    Message, Loading
  },
  methods:{
    saveForm(e){
      const app = this
      app.loading = true
      axios.post('register',app.register)
      .then((resp) => {
        app.$store.commit('user/LOGIN',resp.data)
        app.loading = false
        app.$router.replace('/')
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
}
</script>

<style lang="css" scoped>
  .background {
    background-color: #DADADA !important;
    height: 100vh;
    margin: 1em 0;
  }
  .grid {
    height: 100%;
  }
  .column {
    max-width: 450px;
    text-align: center !important;
  }
</style>

