<template>
  <div> 
    <h4 is="sui-header" color="blue" v-if="status == 0">
      Pesanan Baru
    </h4> 
    <h4 is="sui-header" color="orange" v-else-if="status == 1">
      Pesanan Telah Di Konfirmasi	
    </h4> 
    <h4 is="sui-header" color="purple" v-else-if="status == 2">
      Pesanan Sedang Di Proses
    </h4> 
    <h4 is="sui-header" color="green" v-else-if="status == 3">
      Pesanan Telah Selesai
    </h4> 
    <h4 is="sui-header" color="red" v-else>
      Pesanan Di Batalkan
    </h4> 
  </div>
</template>

<script>
  export default {
    props: ["status"]
  }
</script>
