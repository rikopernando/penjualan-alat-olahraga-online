<template lang="html">
    <div>
      <Header />
        <div class="container" style="margin-top: 70px;">
			    <Breadcrumb active="laporan_penjualan_detail" :breadcrumb="breadcrumb" />
          <h4 class="ui dividing header">Pesanan #{{this.$route.params.id}}</h4>
          <br />
          <br />
      </div>
    </div>
</template>

<script>

    import Header from '../../components/Header'
    import Breadcrumb from '../../components/Breadcrumb'

    export default {
        data: () => ({
          breadcrumb: [{value: 'index',label:'Home'}, {value: 'laporan_penjualan',label:'Laporan Penjualan'}, {value: 'laporan_penjualan_detail',label:'Detail'}],
          loading: false,
          errors: [],
          message: '',
        }),
        mounted(){
          const app = this
          app.findPesanan(app.$route.params.id)
        },
        components:{
          Header, Breadcrumb
        },
        methods: {
          findPesanan(id){
            const app = this
            axios.get(`api/pesanans/${id}`).then((resp) => {
              const { data } = resp
              console.log(data)
            })
            .catch((err) => {
              console.log(err)
              alert(err)
            })
          },
          alert(pesan){
						const app = this
						app.$swal({
							text: pesan,
							icon: "success",
							buttons: false,
							timer: 1000,
						})
          }
        }
  };
</script>
