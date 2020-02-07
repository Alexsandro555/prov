<template>
  <v-container fluid grid-list-sm class="ma-0 pa-0">
    <v-row>
      <v-col>
        <leader-table module="attribute_units"></leader-table>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
  import { mapGetters} from 'vuex'
  export default {
    name: 'AttributeUnit',
    computed: {
      ...mapGetters('attribute_units', ['config'])
    }
  }
</script>
