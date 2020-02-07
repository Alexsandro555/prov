<template>
  <v-row v-if="attributes.length > 0">
    <v-col xs12 class="my-0 py-0">
      <v-card>
        <v-card-text>
          <v-container class="pa-0">
            <v-form ref="form" v-if="attributes.length>0">
              <template v-for="(attribute, index) in attributes">
                <v-container class="pa-0" grid-list-md>
                  <v-layout col wrap>
                    <v-text-field
                      v-if="attribute.attribute_type_id==2"
                      :name="attribute.url_key"
                      :label="attribute.title"
                      :value="attributeValues[attribute.id]?attributeValues[attribute.id].integer_value:null"
                      @input="updateAttribute($event, attribute.id)">
                    </v-text-field>
                    <v-text-field
                      v-else-if="attribute.attribute_type_id==7"
                      :name="attribute.url_key"
                      :label="attribute.title"
                      :value="attributeValues[attribute.id]?attributeValues[attribute.id].double_value:null"
                      @input="updateAttribute($event, attribute.id)"
                      prefix="₽">
                    </v-text-field>
                    <v-text-field
                      v-else-if="attribute.attribute_type_id==3"
                      :name="attribute.url_key"
                      :label="attribute.title"
                      @input="updateAttribute($event, attribute.id)"
                      :value="attributeValues[attribute.id]?attributeValues[attribute.id].integer_value:null"">
                    </v-text-field>
                    <v-text-field
                      v-else-if="attribute.attribute_type_id==4"
                      :name="attribute.url_key"
                      :label="attribute.title"
                      @input="updateAttribute($event.replace(',','.'), attribute.id)"
                      :value="attributeValues[attribute.id]?attributeValues[attribute.id].double_value:null">
                    </v-text-field>
                    <v-checkbox
                      v-else-if="attribute.attribute_type_id==1"
                      :name="attribute.url_key"
                      :label="attribute.title"
                      @change="updateAttribute($event, attribute.id)"
                      :value="attributeValues[attribute.id]?attributeValues[attribute.id].boolean_value:null">
                    </v-checkbox>
                    <v-select
                      :name="attribute.url_key"
                      :items="getListAttributeValues(attribute.id)"
                      :label="attribute.title"
                      :id="attribute.url_key"
                      v-else-if="attribute.attribute_type_id==8"
                      no-data-text="Нет данных"
                      @input="updateAttribute($event, attribute.id)"
                      :value="attributeValues[attribute.id]?attributeValues[attribute.id].list_value:null"
                      item-text="title"
                      item-value="id">
                    </v-select>
                    <v-menu
                      v-else-if="attribute.attribute_type_id==5"
                      v-model="menu"
                      transition="scale-transition"
                      :nudge-left="40"
                      :close-on-content-click="false"
                      full-width>
                      <v-text-field
                        slot="activator"
                        :label="attribute.title"
                        :value="attributeValues[attribute.id]?attributeValues[attribute.id].date_value:null"
                        prepend-icon="event"
                        readonly>
                      </v-text-field>
                      <v-date-picker
                        :allowed-dates="v => v>=dateFns.format(Date.now(),'YYYY-MM-DD')"
                        v-model="date"
                        locale="ru-ru"
                        @change="updateDate({date, id: attribute.id})">
                      </v-date-picker>
                    </v-menu>
                  </v-layout>
                </v-container>
              </template>
            </v-form>
            <v-alert v-else type="error" >
              Нет ни одного привязанного атрибута
            </v-alert>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-col px-3 xs12 text-xs-left>
            <v-btn text-xs-left large color="primary" @click="onSave">Сохранить</v-btn>
          </v-col>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>
<script>
  import { mapState, mapGetters, mapActions } from 'vuex'
  import { GLOBAL } from "@/constants";

  export default {
    name: 'ProductAttributes',
    computed: {
      ...mapState('attribute_values', ['items']),
      ...mapState('attributables', {attributables: 'items'}),
      ...mapState('products', {products: 'items'}),
      ...mapGetters('attribute_list_values', { listAttributeValues: 'items', getByKey: 'getByKey'}),
      ...mapGetters('product_categories', {productCategoryConfig: 'config'}),
      ...mapGetters('type_products', {typeProductConfig: 'config'}),
      ...mapGetters('line_products', {lineProductConfig: 'config'}),
      ...mapGetters('attributables', { transformByKey: 'transformByKey'}),
      ...mapGetters('attribute_values', ['getByKey']),
      attributeValues() {
        return Object.assign({}, ...this.getByKey({product_id: this.$route.params.product_id}).map(item => ({
          [item.attribute_id]: item
        })))
      },
      product() {
        return this.products.find(item => item.id == this.$route.params.product_id)
      },
      getAttributablesProductCategory() {
        return this.attributables.filter(item => item.attributable_id == this.product.product_category_id && item.attributable_type == this.productCategoryConfig.model)
      },
      getAttributablesTypeProduct() {
        return this.attributables.filter(item => item.attributable_id == this.form.type_product_id && item.attributable_type == this.typeProductConfig.model)
      },
      getAttributablesLineProduct() {
        return this.attributables.filter(item => item.attributable_id == this.form.line_product_id && item.attributable_type == this.lineProductConfig.model)
      },
      getAttributebles() {
        return this.getAttributablesProductCategory.concat(this.getAttributablesTypeProduct).concat(this.getAttributablesLineProduct)
      },
      attributes() {
        return _.sortBy(this.getAttributebles.map(item => {
          return Object.assign({}, item, this.transformByKey(item, 'attribute_id'))
        }),[function(o) {return o.sort}])
      }
    },
    data() {
      return {
        form: {},
      }
    },
    methods: {
      ...mapActions('attribute_values', {loadAttributeValuesByKey: GLOBAL.LOAD_BY_KEY, save: GLOBAL.SAVE_DATA}),
      ...mapActions('attributes', {loadAllAttributes: GLOBAL.LOAD_ALL}),
      updateAttribute(value, id) {
        if(this.form[id]) {
          this.form[id] = Object.assign(this.form[id], {value})
        }
        else {
          this.form[id] = {attribute_id: id, product_id: this.$route.params.product_id, value}
        }
      },
      updateDate({date, id}) {
        this.updateAttribute(date, id)
        this.menu = false
      },
      getListAttributeValues(id) {
        return this.listAttributeValues.filter(item => item.attribute_id === id)
      },
      async onSave() {
        let isValid = await this.$validator.validate()
        if (!isValid) {
          return
        }
        let original = Object.assign({}, ...this.getByKey({product_id: this.$route.params.product_id}).map(item => ({
          [item.attribute_id]: {
            attribute_id: item.attribute_id,
            id: item.id,
            product_id: item.product_id,
            value: item.value
          }
        })))

        let arr = []

        for(let prop in this.form) {
          if(original[this.form[prop].attribute_id]) {
            arr.push(Object.assign({}, original[this.form[prop].attribute_id], this.form[prop]))
          } else {
            arr.push(Object.assign({}, this.form[prop], {id: null}))
          }
        }

        this.save(arr)
      },
    }
}
</script>