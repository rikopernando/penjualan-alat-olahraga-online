import Index from '../pages/index.vue'
import Login from '../pages/login.vue'

const routes = [
      {
				path: '/',
				name: 'index',
				component: Index
      },
      {
        path: '/login',
        name: 'login',
        component: Login
      }
    ]

export default routes
