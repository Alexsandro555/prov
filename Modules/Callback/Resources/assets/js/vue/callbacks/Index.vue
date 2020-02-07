<template>
  <v-container fluid grid-list-sm class="ma-0 pa-0">
    <v-row>
      <v-col>
        <leader-table module="callbacks"></leader-table>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
  import { mapGetters} from 'vuex'

  export default {
    name: 'Callbacks',
    computed: {
      ...mapGetters('callbacks', ['config'])
    }
  }
</script>

