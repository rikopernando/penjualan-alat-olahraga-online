require('./bootstrap');

window.Vue = require('vue');

import routes from './routers'
import VueRouter from 'vue-router'
import SuiVue from 'semantic-ui-vue'
import 'semantic-ui-css/semantic.min.css';

window.Vue.use(VueRouter)
window.$ = window.jQuery = require('jquery')

Vue.use(SuiVue)

const router = new VueRouter({ routes })

const app = new Vue({
    router,
}).$mount('#app');
