<template>
  <v-layout align-start justify-left>
    <v-container v-if="loader">
      <v-row class="justify-center align-center">
        <v-col cols="12">
          <v-progress-circular indeterminate :size="100" color="primary"></v-progress-circular>
        </v-col>
      </v-row>
    </v-container>
    <v-card max-width="1200px" width="100%" v-else>
      <v-card-text>
        <v-form ref="form" lazy-validation v-model="validRemainAttr">
          <v-select
            name="product_category_id"
            v-model="form.product_category_id"
            :items="getProductCategories"
            color="white"
            hide-no-data
            item-text="title"
            item-value="id"
            label="Категория продукта"
            no-data-text="Нет данных"
            :rules="getRules({required: true})"
            @change="changeProductCategories"
            :error-messages="messages.product_category_id">
            <template slot="selection" slot-scope="data">
              {{ data.item.title }}
            </template>
          </v-select>
          <v-select
            name="type_product_id"
            v-model="form.type_product_id"
            :items="getTypeProducts"
            color="white"
            hide-no-data
            item-text="title"
            item-value="id"
            no-data-text="Нет данных"
            label="Типы продукта"
            @change="changeTypeProducts"
            :error-messages="messages.type_product_id">
            <template slot="selection" slot-scope="data">
              {{ data.item.title }}
            </template>
          </v-select>
          <v-select
            name="line_product_id"
            v-model="form.line_product_id"
            :items="getLineProducts"
            color="white"
            hide-no-data
            item-text="title"
            item-value="id"
            no-data-text="Нет данных"
            label="Линейки продукции"
            :error-messages="messages.line_product_id">
            <template slot="selection" slot-scope="data">
              {{ data.item.title }}
            </template>
          </v-select>
          <v-autocomplete
            name="attribute_ids"
            :items="getRemainsAttributes"
            color="white"
            hide-no-data
            item-text="title"
            item-value="id"
            :menu-props="{maxHeight: '400'}"
            label="Атрибуты"
            multiple
            persistent-hint
            chips
            :rules="getRules({selected: true})"
            no-data-text="Нет данных"
            v-model="form.selectedRemainAttr"
            placeholder="Введите название атрибута для поиска">
            <template v-slot:selection="data">
              <v-chip
                close
                :input-value="data.selected"
                @input="data.parent.selectItem(data.item)"
                class="chip--select-multi"
                @click:close="remove(data.item, form.selectedRemainAttr)"
                :key="JSON.stringify(data.item)">
                {{ data.item.title }}
              </v-chip>
            </template>
          </v-autocomplete>
          <v-btn large color="primary" :disabled="!validRemainAttr || isSending"
                 @click.prevent="onSaveAttributes()">Сохранить
          </v-btn>
        </v-form>
        <v-form ref="formProductCategoryAttr" lazy-validation v-model="validProdCatAttr">
          <v-select
            label="Атрибуты категории продукции"
            :items="getProductCategoryAttributes"
            v-model="formProductCategoryAttributes"
            multiple
            :menu-props="{maxHeight: '400'}"
            item-text="title"
            item-value="id"
            no-data-text="Нет данных"
            attach
            chips
            :rules="getRules({selected: true})"
            required>
            <template slot="selection" slot-scope="data">
              <v-chip
                close
                @input="data.parent.selectItem(data.item)"
                :input-value="data.selected"
                class="chip--select-multi"
                @click:close="remove(data.item, formProductCategoryAttributes)"
                :key="JSON.stringify(data.item)">
                {{ data.item.title }}
              </v-chip>
            </template>
          </v-select>
          <v-btn large color="primary" :disabled="!validProdCatAttr"
                 @click.prevent="onRemoveProductCategoryAttributes">Исключить атрибуты
          </v-btn>
        </v-form>
        <v-form ref="formTypeProdAttr" lazy-validation v-model="validTypeProdAttr">
          <v-select
            label="Атрибуты типа продукции"
            :items="getTypeProductAttributes"
            v-model="formTypeProductAttributes"
            multiple
            :menu-props="{maxHeight: '400'}"
            item-text="title"
            item-value="id"
            no-data-text="Нет данных"
            persistent-hint
            chips
            :rules="getRules({selected: true})"
            required>
            <template slot="selection" slot-scope="data">
              <v-chip
                close
                @input="data.parent.selectItem(data.item)"
                :input-value="data.selected"
                class="chip--select-multi"
                @click:close="remove(data.item, formTypeProductAttributes)"
                :key="JSON.stringify(data.item)">
                {{ data.item.title }}
              </v-chip>
            </template>
          </v-select>
          <v-btn large color="primary" :disabled="!validTypeProdAttr"
                 @click.prevent="onRemoveTypeProductAttributes">Исключить атрибуты
          </v-btn>
        </v-form>
        <v-form ref="formLineProdAttr" lazy-validation v-model="validLineProdAttr">
          <v-select
            label="Атрибуты линейки продукции"
            :items="getLineProductAttributes"
            v-model="formLineProductAttributes"
            multiple
            :menu-props="{maxHeight: '400'}"
            item-text="title"
            item-value="id"
            no-data-text="Нет данных"
            persistent-hint
            chips
            :rules="getRules({selected: true})"
            required>
            <template slot="selection" slot-scope="data">
              <v-chip
                close
                @input="data.parent.selectItem(data.item)"
                :selected="data.selected"
                class="chip--select-multi"
                @click:close="remove(data.item, formLineProductAttributes)"
                :key="JSON.stringify(data.item)">
                {{ data.item.title }}
              </v-chip>
            </template>
          </v-select>
          <v-btn large color="primary" :disabled="!validLineProdAttr"
                 @click.prevent="onRemoveLineProductAttributes">Исключить атрибуты
          </v-btn>
        </v-form>
      </v-card-text>
    </v-card>
  </v-layout>
</template>

<script>
  import {ACTIONS} from "@product/constants"
  import {GLOBAL} from "@/constants"
  import {mapState, mapActions, mapGetters} from "vuex"
  import {ValidationConvert} from '@/vue/Validations'
  import headingMixin from '@product/mixins/HeadingMixin'

  export default {
    name: 'AttributeBinding',
    data() {
      return {
        loader: false,
        validationConvert: new ValidationConvert(),
        form: {
          selectedRemainAttr: null
        },
        validProdCatAttr: false,
        formProductCategoryAttributes: null,
        validTypeProdAttr: false,
        formTypeProductAttributes: null,
        validLineProdAttr: false,
        formLineProductAttributes: null,
        validRemainAttr: false,
        isSending: false
      }
    },
    mixins: [headingMixin],
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.loader = true
        let attributes = vm.loadAttributes()
        let load = vm.load()
        Promise.all([attributes, load]).then(result => {
          vm.loader = false
        })
      })
    },
    computed: {
      ...mapGetters('attributables', {attributables: 'items', transformByKey: GLOBAL.TRANSFORM_BY_KEY}),
      ...mapState('attributes', {attributes: state => state.bindAttributes, allAttributes: state => state.items}),
      ...mapGetters('product_categories', {productCategoriesConfig: 'config'}),
      ...mapGetters('type_products', {typeProductConfig: 'config'}),
      ...mapGetters('line_products', {getLineProductConfig: 'config'}),
      ...mapState('initializer', ['messages']),
      getProductCategoryAttributes() {
        return this.attributables.filter(item => item.attributable_id == this.form.product_category_id && item.attributable_type == this.productCategoriesConfig.model).map(item => {
          return Object.assign(item, this.transformByKey(item, 'attribute_id'))
        })
      },
      getTypeProductAttributes() {
        return this.attributables.filter(item => item.attributable_id == this.form.type_product_id && item.attributable_type == this.typeProductConfig.model).map(item => {
          return Object.assign(item, this.transformByKey(item, 'attribute_id'))
        })
      },
      getLineProductAttributes() {
        return this.attributables.filter(item => item.attributable_id == this.form.line_product_id && item.attributable_type == this.getLineProductConfig.model).map(item => {
          return Object.assign(item, this.transformByKey(item, 'attribute_id'))
        })
      },
      getSelAttributesIds() {
        return this.getProductCategoryAttributes.concat(this.getTypeProductAttributes).concat(this.getLineProductAttributes).map(item => item.attribute_id)
      },
      getRemainsAttributes() {
        return this.allAttributes.filter(item => !this.getSelAttributesIds.includes(item.id))
      }
    },
    watch: {
      getProductCategoryAttributes(val) {
        this.formProductCategoryAttributes = val.map(item => item.attribute_id)
      },
      getTypeProductAttributes(val) {
        this.formTypeProductAttributes = val.map(item => item.attribute_id)
      },
      getLineProductAttributes(val) {
        this.formLineProductAttributes = val.map(item => item.attribute_id)
      }
    },
    methods: {
      onSaveAttributes() {
        if (this.$refs.form.validate()) {
          this.isSending = true
          this.save(this.form).then(response => {
            this.isSending = false
            this.form.selectedRemainAttr = null
          }).catch(error => {
            this.isSending = false
          })
        }
      },
      onRemoveProductCategoryAttributes() {
        if (this.$refs.formProductCategoryAttr.validate()) {
          let data = {
            'toggled_ids': this.formProductCategoryAttributes,
            'id': this.form.product_category_id,
            'relation': 'attributes'
          }
          this.isSending = true
          this.toggleProductCategories({ data, module: 'attributables'}).then(response => {
            this.isSending = false
          }).catch(error => this.isSending = false)
        }
      },
      onRemoveTypeProductAttributes() {
        if (this.$refs.formTypeProdAttr.validate()) {
          this.isSending = true
          let data = {
            'toggled_ids': this.formTypeProductAttributes,
            'id': this.form.type_product_id,
            'relation': 'attributes'
          }
          this.toggleTypeProducts({ data, module: 'attributables'}).then(response => {
            this.isSending = false
          }).catch(error => this.isSending = false)
        }
      },
      onRemoveLineProductAttributes() {
        if (this.$refs.formLineProdAttr.validate()) {
          this.isSending = true
          let data = {
            'toggled_ids': this.formLineProductAttributes,
            'id': this.form.line_product_id,
            'relation': 'attributes'
          }
          this.toggleLineProducts({ data, module: 'attributables'}).then(response => {
            this.isSending = false
          }).catch(error => this.isSending = false)
        }
      },
      getRules(validations) {
        return validations ? this.validationConvert.ruleValidations(validations) : []
      },
      remove(item, list) {
        const index = list.indexOf(item.id)
        if (index >= 0) list.splice(index, 1)
      },
      ...mapActions('attributables', {
        load: GLOBAL.LOAD_ALL,
        save: GLOBAL.SAVE_DATA,
      }),
      ...mapActions('attributes', {
        initialization: GLOBAL.INITIALIZATION,
        loadAttributes: GLOBAL.LOAD_ALL
      }),
      ...mapActions('product_categories', {toggleProductCategories: GLOBAL.TOGGLE}),
      ...mapActions('type_products', {toggleTypeProducts: GLOBAL.TOGGLE}),
      ...mapActions('line_products', {toggleLineProducts: GLOBAL.TOGGLE})
    }
  }
</script>