<template>
    <sui-table-body>
      <sui-table-row v-for="item, index in data" :key="index">
           <sui-table-cell v-for="value, i in item" :key="i">
              <TableStatus :status="value" v-if="i == 'status_pesanan'" />
              <p v-else>{{value}}</p>
           </sui-table-cell>
           <sui-table-cell v-if="edit != 0">
              <router-link :to="{name: edit, params: {id: item.id}}" class="ui green button">{{labelEdit}}</router-link>
           </sui-table-cell>
           <sui-table-cell>
               <sui-button color="red" content="Hapus" v-on:click="handleDelete(item.id)" />
           </sui-table-cell>
      </sui-table-row>
    </sui-table-body>
</template>

<script>
  import TableStatus from './TableStatus'
  export default {
    props: ["data","edit","labelEdit"],
    components: {
      TableStatus
    },
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
