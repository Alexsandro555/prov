<template>
  <v-container fluid fill-height grid-list-sm class="ma-0 pa-0">
    <v-row>
      <v-col class="pa-0 ma-0" style="min-width: 330px; max-width:330px">
        <template>
          <v-card>
            <v-container v-if="loading" height="100" width="100" fill-height>
              <v-row justify="center" align="center">
                <v-progress-circular indeterminate :size="50" mx-auto color="primary"></v-progress-circular>
              </v-row>
            </v-container>
            <v-list v-else three-line>
              <v-list-item>
                <v-text-field name="search" v-model="search" label="Поисковая фраза..." single-line outlined></v-text-field>
              </v-list-item>
              <template v-for="(product,index) in search?filteredProducts:items">
                <v-list-item :key="product.id" :to="'/products/'+product.id">
                  <v-list-item-content>
                    <v-list-item-subtitle class="subtitle-1">{{product.title}}</v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
              </template>
            </v-list>
          </v-card>
        </template>
      </v-col>
      <v-col class="pa-0 ma-0">
        <router-view/>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
  import { mapGetters, mapState, mapActions } from 'vuex'
  import { GLOBAL } from "@/constants";

  export default {
    name: 'Products',
    computed: {
      ...mapGetters('products', ['items', 'config']),
      ...mapState('products', { loading: 'isLoading' }),
      filteredProducts() {
        return this.items.filter(item => {
          return item.title.match(this.search)
        })
      }
    },
    data() {
      return {
        search: null
      }
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.loadAll()
          .then(response => (!_.isNil(response)) && vm.loadDeep(response) && vm.loadAllAttributables() && vm.loadAttributeListValues() && vm.loadFilesByKey({ fileable_type: vm.config.model, fileable_id: response.map(item => item.id) }))
      })
    },
    methods: {
      ...mapActions('products', { loadAll: GLOBAL.LOAD_ALL, loadDeep: GLOBAL.LOAD_DEEP }),
      ...mapActions('attributables', { loadAllAttributables: GLOBAL.LOAD_ALL }),
      ...mapActions('attribute_list_values', { loadAttributeListValues: GLOBAL.LOAD_ALL }),
      ...mapActions('files', { loadFilesByKey: GLOBAL.LOAD_BY_KEY })
    }
  }
</script>


