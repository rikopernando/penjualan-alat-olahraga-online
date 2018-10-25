<template>
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="profil" :breadcrumb="breadcrumb" />
          <h4 class="ui dividing header">{{profile.name}}</h4>
					<sui-grid>
						<sui-grid-column :width="3">
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

						<sui-grid-column stretched :width="13">
							<sui-segment>
                <DashboardProfil v-if="active == 'Dashboard'" 
                  :name="profile.name"
                  :no_telp="profile.no_telp"
                  :alamat="profile.alamat"
                  :email="profile.email"
                />
							</sui-segment>
						</sui-grid-column>
					</sui-grid>
        </div>
    </div>
</template>

<script>

  import Header from '../../components/Header'
  import Breadcrumb from '../../components/Breadcrumb'
  import DashboardProfil from '../../components/DashboardProfil'
  import { mapState } from 'vuex'

  export default {
    data: () => ({
      breadcrumb: [{value: 'index',label:'Home'}, {value: 'profil',label:'Profil'}],
      items: ['Dashboard','Pesanan Saya'],
      active: 'Dashboard',
    }),
    components:{
      Header, Breadcrumb, DashboardProfil
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
