<template>
    <sui-table-body>
      <sui-table-row v-for="item, index in data" :key="index">
           <sui-table-cell v-for="value, i in item" :key="i">
              {{value}} 
           </sui-table-cell>
           <sui-table-cell>
              <router-link :to="{name: edit}" class="ui green button">Edit</router-link>
           </sui-table-cell>
           <sui-table-cell>
               <sui-button color="red" content="Hapus" v-on:click="handleDelete(item.id)" />
           </sui-table-cell>
      </sui-table-row>
    </sui-table-body>
</template>

<script>
  export default {
    props: ["data","edit"],
    methods: {
      handleDelete(id){
        const app = this
        app.$swal({
          text: `Anda Yakin Ingin Menghapus Data ini ?`,
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          willDelete ? app.$emit('delete',id) : app.$swal.close()
        })
      }
    }
  }
</script>
