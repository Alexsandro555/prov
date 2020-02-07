<template>
  <v-container fluid grid-list-sm class="ma-0 pa-0">
    <v-row>
      <v-col>
        <leader-table module="product_categories">
          <template v-slot:files="{id}">
            <file-box :fileable-id="id" :type-files="config.type_files" :model="config.model"/>
          </template>
        </leader-table>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
  import { mapGetters} from 'vuex'
  export default {
    name: 'ProductCategory',
    computed: {
      ...mapGetters('product_categories', ['config'])
    }
  }
</script>
