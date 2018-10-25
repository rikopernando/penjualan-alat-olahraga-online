<template>
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="profil" :breadcrumb="breadcrumb" />
          <h4 class="ui dividing header">Profil</h4>
					<sui-grid>
						<sui-grid-column :width="4">
							<sui-menu fluid vertical tabular>
								<a
									v-for="item in items"
									:key="item"
									is="sui-menu-item"
									:content="item"
									:active="isActive(item)"
									@click="select(item)"
								/>
							</sui-menu>
						</sui-grid-column>

						<sui-grid-column stretched :width="12">
							<sui-segment>
                <table class="ui definition table">
                  <tbody>
                    <tr>
                      <td class="two wide column">Nama</td>
                      <td>{{profile.name}}</td>
                    </tr>
                    <tr>
                      <td>No. Telepon</td>
                      <td>{{profile.no_telp}}</td>
                    </tr>
                    <tr>
                      <td>Email</td>
                      <td>{{profile.email}}</td>
                    </tr>
                    <tr>
                      <td>Alamat</td>
                      <td>{{profile.alamat}}</td>
                    </tr>
                  </tbody>
                </table> 
							</sui-segment>
						</sui-grid-column>
					</sui-grid>
        </div>
    </div>
</template>

<script>

  import Header from '../../components/Header'
  import Breadcrumb from '../../components/Breadcrumb'
  import { mapState } from 'vuex'

  export default {
    data: () => ({
      breadcrumb: [{value: 'index',label:'Home'}, {value: 'profil',label:'Profil'}],
      items: ['Dashboard'],
      active: 'Dashboard',
    }),
    components:{
      Header, Breadcrumb
    },
    computed : mapState ({
       profile() {
        return this.$store.state.user.profile
       },
    }),
		methods: {
			isActive(name) {
				return this.active === name;
			},
			select(name) {
				this.active = name;
			},
		},
  }
</script>
