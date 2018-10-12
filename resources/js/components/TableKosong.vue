<template>
    <sui-table-body v-else>
      <sui-table-row>
        <sui-table-cell :colspan="colspan">
            <h6 is="sui-header" text-align="center">
                {{ text }}
            </h6>
        </sui-table-cell>
      </sui-table-row>
    </sui-table-body>
</template>

<script>
    export default {
      props: ["colspan","text"]
    }
</script>
