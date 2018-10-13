<template lang="html">
  <div>
    <sui-menu fixed inverted>
      <sui-container>
            <a href="#" is="sui-menu-item" class="header">
              Project Name
            </a>

            <router-link :to="{name: 'index'}"
              class="item" 
              v-if="this.$store.state.user.loggedIn">
               Home
            </router-link>

            <sui-dropdown 
              text="Master Data"
              item class="simple"
              v-if="this.$store.state.user.is_admin || this.$store.state.user.is_owner">
                  <sui-dropdown-menu>
                    <router-link :to="{name: 'user'}" class="item"> 
                       User
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

              <router-link :to="{name: 'logout'}"
                class="item"
                v-if="this.$store.state.user.loggedIn">
                  Logout
              </router-link>

      	</sui-menu-menu>
      </sui-container>
    </sui-menu>
  </div>
</template>

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

