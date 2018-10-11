<template lang="html">
	 <div class="ui breadcrumb">
      <span v-for="item, index in breadcrumb">
           <router-link :to="{name: item.value}" class="active section" v-if="item.value == active">
              {{item.label}}
           </router-link>
           <router-link :to="{name: item.value}" class="link section" v-else>
              {{item.label}}
            </router-link>
          <div class="divider">/</div>
      </span>
  	</div>
</template>

<script>
  export default {
    props: ['active','breadcrumb'],
  }
</script>
