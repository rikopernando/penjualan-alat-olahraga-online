<template>
    <table class="ui definition table">
      <tbody>
        <tr>
          <td class="two wide column">Nama</td>
          <td>{{name}}</td>
        </tr>
        <tr>
          <td>No. Telepon</td>
          <td>{{no_telp}}</td>
        </tr>
        <tr>
          <td>Email</td>
          <td>{{email}}</td>
        </tr>
        <tr>
          <td>Alamat</td>
          <td>{{alamat}}</td>
        </tr>
      </tbody>
    </table> 
</template>

<script>
  export default {
    props: ["name","no_telp","email","alamat"]
  }
</script>
