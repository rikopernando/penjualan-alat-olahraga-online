<template>
  <div>
    <br />
    <br />
    <sui-segment inverted vertical class="footer">
      <sui-container text-align="center">
        <sui-grid class="inverted" stackable divided>
          <sui-grid-row>
            <sui-grid-column :width="5">
              <sui-list class="inverted" link>
                <h4 is="sui-header" content="Tentang Kami" class="inverted" />
								<p>Tentang Kami ... </p>
              </sui-list>
            </sui-grid-column>
            <sui-grid-column :width="5">
              <sui-list class="inverted" link>
                <h4 is="sui-header" content="Info Tentang Kami" class="inverted" />
								<p>Info Tentang Kami ... </p>
              </sui-list>
            </sui-grid-column>
            <sui-grid-column :width="5">
              <sui-list class="inverted" link>
                <h4 is="sui-header" content="Ikuti Kami Di" class="inverted" />
                <a is="sui-list-item" href="#"><sui-icon name="facebook" size="large"/> facebook</a>
                <a is="sui-list-item" href="#"><sui-icon name="instagram" size="large"/>instagram</a>
                <a is="sui-list-item" href="#"><sui-icon name="twitter" size="large"/>twitter</a>
              </sui-list>
            </sui-grid-column>
          </sui-grid-row>
        </sui-grid>

        <sui-divider inverted section />
        </sui-list>
      </sui-container>
    </sui-segment>
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

