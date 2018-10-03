import Index from '../pages/index'
import Login from '../pages/login'
import Register from '../pages/register'

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
      },
      {
        path: '/register',
        name: 'register',
        component: Register
      }
    ]

export default routes
