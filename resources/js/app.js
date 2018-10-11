require('./bootstrap');
import Vue from 'vue'

window.Vue = Vue 

import routes from './routers'
import store from './store'
import VueRouter from 'vue-router'
import SuiVue from 'semantic-ui-vue'
import 'semantic-ui-css/semantic.min.css';

window.Vue.use(VueRouter)
window.$ = window.jQuery = require('jquery')

Vue.use(SuiVue)

const router = new VueRouter({ routes })

router.beforeEach((to, from, next) => {

  axios.get('auth')
  .then((resp) => {
   resp.data && store.commit(`user/LOGIN`,resp.data)
   resp.data ? beforeRoute(true,resp.data.role.role_id) : beforeRoute(false,0) 
 })
  .catch((err) => {
    console.log(err)
  })

  const beforeRoute = (loggedIn, role) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
      
      if (!loggedIn) {
        next({ path: '/'})
      }else if(to.matched.some(record => record.meta.is_owner)){
        role == "1" ? next() : next({path:'/'})	
      }else if(to.matched.some(record => record.meta.is_admin)){
        (role == "2" || role == "1") ? next() : next({path:'/'})	
      }else {
        next()
      }

    }else {
     if(to.matched.some(record => record.meta.is_guest)){
       loggedIn ? next({path:'/'}) : next()
     }else{
       next()
     }
   }

}

})

const app = new Vue({
  router,store
}).$mount('#app');
