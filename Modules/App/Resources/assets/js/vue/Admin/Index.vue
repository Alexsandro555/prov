<template>
  <div>
    <core-filter />
    <core-toolbar />
    <core-drawer />
    <v-content fill-height pa-0 ma-0>
      <v-fade-transition mode="out-in">
        <router-view/>
      </v-fade-transition>
    </v-content>
    <notifications/>
  </div>
</template>
<script>
  export default {
    name: 'Admin'
  }
</script>