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
import LaporanPenjualanDetail from '../pages/laporan_penjualan/detail'
import BankIndex from '../pages/bank'
import BankCreate from '../pages/bank/create'
import BankEdit from '../pages/bank/edit'
import Profil from '../pages/profil'
import DetailPesananSaya from '../pages/profil/detail_pesanan'

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
        path: '/bank',
        name: 'bank',
        component: BankIndex,
        meta: {
            requiresAuth: true,
            is_admin: true
        }
      },
      {
        path: '/bank/create',
        name: 'bank_create',
        component: BankCreate,
        meta: {
            requiresAuth: true,
            is_admin: true
        }
      },
      {
        path: '/bank/edit/:id',
        name: 'bank_edit',
        component: BankEdit,
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
        path: '/laporan-penjualan/detail/:id',
        name: 'laporan_penjualan_detail',
        component: LaporanPenjualanDetail,
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
        path: '/profil',
        name: 'profil',
        component: Profil,
        meta: {
            requiresAuth: true,
        }
      },
      {
        path: '/pesanan-saya/:id',
        name: 'detail_pesanan_saya',
        component: DetailPesananSaya,
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
