<template>
  <v-container fluid grid-list-sm class="ma-0 pa-0">
    <v-row>
      <v-col>
        <leader-table module="attribute_list_values" :loading="isLoading" :items="list" :elements="formFields" :relations="relations" :save="save" :del="del" :rules="rules"></leader-table>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import { GLOBAL } from "@/constants";
  import { mapActions, mapState, mapGetters } from 'vuex'

  export default {
    name: 'AttributeListValue',
    props: {
      attributeId: {
        type: Number,
        required: true
      }
    },
    data() {
      return {}
    },
    mounted() {
      this.loadAll()
    },
    computed: {
      list() {
        return this.items.filter(item => item.attribute_id === this.attributeId)
      },
      ...mapState('attribute_list_values', ['items', 'isLoading', 'formFields', 'relations', 'rules']),
      ...mapGetters('attribute_list_values', ['config'])
    },
    methods: {
      save(obj) {
        return new Promise((resolve, reject) => {
          let data = Object.assign({}, obj, {attribute_id: Number(this.attributeId)})
          resolve(this.saveData(data))
        }).catch(error => {
          reject(error)
        })
      },
      ...mapActions('attribute_list_values', {
        loadAll: GLOBAL.LOAD_ALL,
        saveData: GLOBAL.SAVE_DATA,
        del: GLOBAL.DELETE
      })
    }
  }
</script>

<style scoped>
  .full-width {
    width: 100%
  }
</style>