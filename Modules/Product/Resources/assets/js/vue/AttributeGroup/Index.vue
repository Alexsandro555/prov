<template>
  <v-container fluid grid-list-sm class="ma-0 pa-0">
    <v-row>
      <v-col>
        <leader-table module="attribute_groups"></leader-table>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
  import { mapGetters} from 'vuex'
  export default {
    name: 'AttributeGroup',
    computed: {
      ...mapGetters('attribute_groups', ['config'])
    }
  }
</script>
