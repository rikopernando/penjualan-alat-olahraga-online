import Index from '../pages/index'
import Logout from '../pages/logout.vue'
import Login from '../pages/login'
import Register from '../pages/register'
import Dashboard from '../pages/dashboard'
import UserIndex from '../pages/user'
import UserCreate from '../pages/user/create'

const routes = [
      {
				path: '/',
				name: 'index',
				component: Index
      },
      {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            is_guest: true
        }
      },
      {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            is_guest: true
        }
      },
      {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: {
            requiresAuth: true,
            is_admin: true
        }
      },
      {
        path: '/user',
        name: 'user',
        component: UserIndex,
        meta: {
            requiresAuth: true,
            is_admin: true
        }
      },
      {
        path: '/user/create',
        name: 'user_create',
        component: UserCreate,
        meta: {
            requiresAuth: true,
            is_admin: true
        }
      },
      {
        path: '/logout',
        name: 'logout',
        component: Logout
      },
    ]

export default routes
