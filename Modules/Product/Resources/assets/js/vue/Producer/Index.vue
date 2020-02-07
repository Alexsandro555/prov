<template>
  <v-container fluid grid-list-sm class="ma-0 pa-0">
    <v-row>
      <v-col>
        <leader-table module="producers"></leader-table>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
  import { mapGetters} from 'vuex'
  export default {
    name: 'Producer',
    computed: {
      ...mapGetters('producers', ['config'])
    }
  }
</script>

