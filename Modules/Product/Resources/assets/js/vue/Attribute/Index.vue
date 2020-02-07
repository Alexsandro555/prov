<template>
  <v-container fluid grid-list-sm class="ma-0 pa-0">
    <v-row>
      <v-col>
        <leader-table module="attributes">
          <template v-slot:subtable="{ id }">
            <leader-table v-if="checkAttribute(id)" module="attribute_list_values" :custom-items="customItems(id)"></leader-table>
          </template>
        </leader-table>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
  import { GLOBAL } from "@/constants"
  import { mapGetters, mapState, mapActions } from 'vuex'

  export default {
    name: 'Attribute',
    computed: {
      ...mapState('attribute_list_values', ['items']),
      ...mapState('attributes', { attributes: 'items' }),
      ...mapGetters('attributes', ['config'])
    },
    methods: {
      checkAttribute(id) {
        return this.attributes.find(item => item.id == id && item.attribute_type_id == 8)
      },
      customItems(id) {
        return this.items.filter(item => item.attribute_id == id) || []
      }
    }
  }
</script>



