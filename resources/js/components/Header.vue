<template lang="html">
  <div>
    <sui-menu fixed inverted>
      <sui-container>
            <router-link :to="{name: 'index'}"
              class="header item">
              Satria Shop
            </router-link>

            <router-link :to="{name: 'index'}" class="item" v-if="this.$store.state.user.loggedIn">
               Home
            </router-link>

            <router-link :to="{name: 'laporan_penjualan'}" class="item"  v-if="this.$store.state.user.is_admin || this.$store.state.user.is_owner">
               Pesanan Penjualan
            </router-link>

            <sui-dropdown 
              text="Master Data"
              item class="simple"
              v-if="this.$store.state.user.is_admin">
                  <sui-dropdown-menu>
                    <router-link :to="{name: 'user'}" class="item"> 
                       User
                    </router-link>
                    <router-link :to="{name: 'produk'}" class="item"> 
                       Produk
                    </router-link>
                    <router-link :to="{name: 'bank'}" class="item"> 
                       Bank
                    </router-link>
                  </sui-dropdown-menu>
            </sui-dropdown>

            <sui-dropdown 
              text="Laporan"
              item class="simple"
              v-if="this.$store.state.user.is_admin || this.$store.state.user.is_owner">
                  <sui-dropdown-menu>
                    <router-link :to="{name: 'laporan_kas'}" class="item"> 
                      Laporan Kas
                    </router-link>
                  </sui-dropdown-menu>
            </sui-dropdown>

      	<sui-menu-menu position="right">

              <router-link :to="{name: 'login'}" 
                class="item"
                v-if="!this.$store.state.user.loggedIn">
                  Login
              </router-link>

              <router-link :to="{name: 'register'}"
                class="item"
                v-if="!this.$store.state.user.loggedIn">
                  Register
              </router-link>

              <router-link :to="{name: 'keranjang'}" class="item" v-if="this.$store.state.user.is_member">
                  Keranjang
								<sui-label circular color="grey">
                  {{this.$store.state.keranjang.jumlah}}   
                </sui-label>
              </router-link>

            <sui-dropdown 
              v-bind:text="this.$store.state.user.profile.name"
              item class="simple"
              v-if="this.$store.state.user.loggedIn">
                  <sui-dropdown-menu>
                      <router-link :to="{name: 'profil'}"
                        class="item"
                        v-if="this.$store.state.user.loggedIn">
                          Profil
                      </router-link>
                      <router-link :to="{name: 'logout'}"
                        class="item"
                        v-if="this.$store.state.user.loggedIn">
                          Logout
                      </router-link>
                  </sui-dropdown-menu>
            </sui-dropdown>

      	</sui-menu-menu>
      </sui-container>
    </sui-menu>
  </div>
</template>

<script>
  export default {
    mounted(){
      const app = this
      const pelanggan = app.$store.state.user.profile.id 
      this.$store.dispatch('keranjang/LOAD_KERANJANG',{page: 1, search:'',pelanggan:pelanggan})
    }
  }
</script>

<style lang="css" scoped>
img.logo {
  margin-right: 1.5em !important;
}
.main {
  margin-top: 7em;
}
.wireframe {
  margin: 2em 0;
}
.footer {
  margin: 5em 0em 0em;
  padding: 5em 0em;
}
</style>
