<template lang="html">
  <div>
    <sui-menu fixed inverted>
      <sui-container>
        <a href="#" is="sui-menu-item" class="header">
          Project Name
        </a>

        <a is="sui-menu-item" href="#">Home</a>

        <sui-dropdown text="Dropdown" item class="simple">
          <sui-dropdown-menu>
            <a is="sui-dropdown-item" href="#">Link Item</a>
            <a is="sui-dropdown-item" href="#">Link Item</a>

            <sui-dropdown-divider />
            <sui-dropdown-header>Header Item</sui-dropdown-header>

            <sui-dropdown-item>
              <sui-icon name="dropdown" /> Submenu

              <sui-dropdown-menu class="simple">
                <a is="sui-dropdown-item" href="#">Link Item</a>
                <a is="sui-dropdown-item" href="#">Link Item</a>
              </sui-dropdown-menu>
            </sui-dropdown-item>

            <a is="sui-dropdown-item" href="#">Link Item</a>
          </sui-dropdown-menu>
        </sui-dropdown>
      	<sui-menu-menu position="right">
          <router-link :to="{name: 'login'}" class="item">Login</router-link>
          <router-link :to="{name: 'register'}" class="item">Register</router-link>
      	</sui-menu-menu>
      </sui-container>
    </sui-menu>
  </div>
</template>

<script>
export default {
};
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

