import Index from '../pages/index'
import Logout from '../pages/logout.vue'
import Login from '../pages/login'
import Register from '../pages/register'
import UserIndex from '../pages/user'
import UserCreate from '../pages/user/create'
import UserEdit from '../pages/user/edit'
import ProdukIndex from '../pages/produk'
import ProdukCreate from '../pages/produk/create'
import ProdukEdit from '../pages/produk/edit'
import Keranjang from '../pages/keranjang'
import Checkout from '../pages/checkout'
import LaporanPenjualan from '../pages/laporan_penjualan'

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
        path: '/user/edit/:id',
        name: 'user_edit',
        component: UserEdit,
        meta: {
            requiresAuth: true,
            is_admin: true
        }
      },
      {
        path: '/produk',
        name: 'produk',
        component: ProdukIndex,
        meta: {
            requiresAuth: true,
            is_admin: true
        }
      },
      {
        path: '/produk/create',
        name: 'produk_create',
        component: ProdukCreate,
        meta: {
            requiresAuth: true,
            is_admin: true
        }
      },
      {
        path: '/produk/edit/:id',
        name: 'produk_edit',
        component: ProdukEdit,
        meta: {
            requiresAuth: true,
            is_admin: true
        }
      },
      {
        path: '/laporan-penjualan',
        name: 'laporan_penjualan',
        component: LaporanPenjualan,
        meta: {
            requiresAuth: true,
            is_owner: true
        }
      },
      {
        path: '/keranjang',
        name: 'keranjang',
        component: Keranjang,
        meta: {
            requiresAuth: true,
        }
      },
      {
        path: '/checkout',
        name: 'checkout',
        component: Checkout,
        meta: {
            requiresAuth: true,
        }
      },
      {
        path: '/logout',
        name: 'logout',
        component: Logout
      },
    ]

export default routes
