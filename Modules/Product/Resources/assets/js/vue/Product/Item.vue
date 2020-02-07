<template>
  <v-row>
    <v-col xs12 class="ma-0 pa-0" style="min-width: 930px; max-width:930px" v-if="!loading">
      <v-card>
        <v-card-title>
          <v-row class="no-gutters">
            <v-col cols="9">

            </v-col>
            <v-col cols="3" class="text-right">
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn @click="onSave" v-on="on" text icon color="primary">
                    <v-icon>save</v-icon>
                  </v-btn>
                </template>
                <span>Сохранить</span>
              </v-tooltip>
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn @click="goToProduct" v-on="on" text icon color="lime">
                    <v-icon>find_in_page</v-icon>
                  </v-btn>
                </template>
                <span>К товару</span>
              </v-tooltip>
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn @click="goTo('/products/'+product.id+'/attributes')" v-on="on" text icon color="pink">
                    <v-icon>edit_attributes</v-icon>
                  </v-btn>
                </template>
                <span>Атрибуты</span>
              </v-tooltip>

            </v-col>
            <!--<v-col >
              <v-btn :to="'/products/'+product.id+'/attributes'" text icon dark class="mx-0" small color="primary"><v-icon dark>edit_attributes</v-icon></v-btn>
              <v-btn :to="'/products/'+product.id+'/attributes'" text icon dark class="mx-0" small color="primary"><v-icon dark>edit_attributes</v-icon></v-btn>
            </v-col>-->
          </v-row>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form>
              <template v-for="(field, num) in filterFields">
                <input
                  type="hidden"
                  v-if="field.primary"
                  :name="num"
                  :value="product[num]"
                  hidden/>
                <v-text-field
                  v-else-if="field.type=='string'"
                  :name="num"
                  v-validate="getRules(num)"
                  :data-vv-name="num"
                  :label="field.label"
                  :value="product[num]"
                  :error-messages="errors.first(num) || messages[num]"
                  @input="updateItem($event,num)">
                </v-text-field>
                <v-text-field
                  v-else-if="field.type=='decimal'"
                  :name="num"
                  :v-validate="getRules(num)"
                  :data-vv-name="num"
                  :label="field.label"
                  :value="product[num]"
                  prefix="₽"
                  :error-messages="errors.first(num)"
                  @input="updateItem($event.replace(',','.'),num)">
                </v-text-field>
                <v-text-field
                  v-else-if="field.type=='integer' && !field.primary"
                  :name="num"
                  :label="field.label"
                  :value="product[num]"
                  v-validate="getRules(num)"
                  :data-vv-name="num"
                  :error-messages="errors.first(num)"
                  @input="updateItem($event,num)">
                </v-text-field>
                <!--<wysiwyg
                  v-else-if="field.type=='text'"
                  :element-id="String(product.id)"
                  :name="num"
                  url="image-wysiwyg-upload"
                  url-file="upload-file"
                  type-file-upload="file"
                  type-file="image-wysiwyg"
                  :model="getModel"
                  :value="product[num]"
                  @input="updateItem($event,num)">
                </wysiwyg>-->
                <wysiwyg-index
                  v-else-if="field.type=='text'"
                  :id="product_id"
                  :name="num"
                  url="files"
                  url-file="upload-file"
                  type-file-upload="file"
                  type-file="image-wysiwyg"
                  :model="config.model"
                  :value="product[num]"
                  @input="updateItem($event,num)">
                </wysiwyg-index>
                <v-checkbox
                  v-else-if="field.type=='boolean'"
                  :label="field.label"
                  :name="num"
                  type="checkbox"
                  v-validate="getRules(num)"
                  :data-vv-name="num"
                  v-model="product[num]"
                  @change="updateItemCheckbox($event,num)"
                  :error-messages="errors.first(num)">
                </v-checkbox>
                <v-autocomplete
                  v-else-if="field.type=='selectbox'"
                  :value="product[num]"
                  @change="updateItem($event,num)"
                  :items="getItems(num)"
                  color="white"
                  hide-no-data
                  :name="num"
                  item-text="title"
                  item-value="id"
                  :label="field.label"
                  v-validate="getRules(num)"
                  :data-vv-name="num"
                  :error-messages="errors.first(num)"
                  placeholder="Введите поисковую фразу">
                  <template slot="selection" slot-scope="data">
                    {{ data.item.title }}
                  </template>
                </v-autocomplete>
              </template>
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
                v-validate="getRules('required')"
                :data-vv-name="'product_category_id'"
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
              <div v-if="sections.length > 0">
                Разделы:
                <v-row>
                  <v-col cols="3" :key="section.id" v-for="section in sections">
                    <v-checkbox :key="section.id" :label='section.title' :input-value="check(section.id)" @change="changeSection({'section_id': section.id, 'event': $event})"></v-checkbox>
                  </v-col>
                </v-row>
              </div>
              <slot :id="product.id" name="file-upload">
                <v-row class="justify-end align-content-end">
                  <v-col cols="10">
                    <file-box :fileable-id="product_id" :type-files="config.type_files" :model="getModel"/>
                  </v-col>
                  <v-col cols="2">
                    <file-custom :fileable-id="product_id" :type-files="config.type_files" :model="getModel"/>
                  </v-col>
                </v-row>
              </slot>
              <slot :id="product.id" name="subtable"></slot>
            </v-form>
          </v-container>
        </v-card-text>
        <!--<v-card-actions>
          <v-col pa-1 xs12 text-xs-left>
            <v-btn text-xs-left large color="primary" @click="onSave">Сохранить</v-btn>
          </v-col>
        </v-card-actions>-->
      </v-card>
    </v-col>
    <v-col class="pa-0 ma-0">
      <router-view/>
    </v-col>
  </v-row>
</template>
<script>
  import { GLOBAL } from "@/constants";
  import { mapState, mapGetters, mapActions } from 'vuex'
  import wysiwyg from '@initializer/vue/wysiwyg'
  import headingMixin from '@product/mixins/HeadingMixin'

  export default {
    name: 'Product',
    $_veeValidate: {
      validator: 'new',
    },
    props: {
      product_id: {
        type: Number,
        required: true
      },
    },
    data() {
      return {
        editedItem: null,
      }
    },
    computed: {
      ...mapState('products', ['items', 'formFields']),
      ...mapState('initializer', ['messages']),
      ...mapState('sections', {sections: 'items'}),
      ...mapGetters('products', {rules: 'rules', config: 'config', getProductByKey: 'getByKey', getModel: 'getModel', loading: 'loading'}),
      ...mapGetters('product_section', {configProductSection: 'config', productSectionItems: 'items', transformByKey: 'transformByKey'}),
      product() {
        this.form = Object.assign({}, _.pick(this.getProductByKey(this.product_id), ['product_category_id', 'type_product_id', 'line_product_id']))
        return Object.assign({}, this.getProductByKey(this.product_id))
      },
      filterFields() {
        return _.omit(this.formFields, ['product_category_id', 'type_product_id', 'line_product_id'])
      },
      productSection() {
        return this.productSectionItems.filter(item => item.product_id == this.product_id) /*.map(item => ({
          [item.section_id]: item
        }))*/
      }
    },
    /*beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.load(to.params.product_id)
      })
    },
    beforeRouteUpdate(to, from, next) {
      this.load(to.params.product_id)
      next()
    },*/
    mixins: [headingMixin],
    components: {
      wysiwyg,
    },
    methods: {
      ...mapActions('products', {save: GLOBAL.SAVE_DATA}),
      ...mapActions('product_section', {saveProductSection: GLOBAL.SAVE_DATA}),
      goToProduct() {
        window.open('/catalog/detail/'+this.product.url_key, '_blank');
      },
      goTo(url) {
        if (this.$route.path !== url) {
          this.$router.push(url);
        }
      },
      check(section_id) {
        return !_.isNil(this.productSection.find(item => item.section_id == section_id))
      },
      changeSection({section_id, event}) {
        if(event) {
          this.productSection.push({product_id: this.product_id, section_id, id: null})
        } else {
          _.remove(this.productSection, item => item.section_id == section_id)
        }
      },
      getRules(num) {
        return !_.isUndefined(this.rules[num]) ? '' + this.rules[num] : ''
      },
      updateField(objField) {
        this.editedItem = Object.assign({}, this.editedItem, objField)
      },
      updateItem(value, key) {
        let objField = {}
        objField[key] = value
        this.updateField(objField)
      },
      updateItemCheckbox(value, key) {
        let objField = {}
        objField[key] = Boolean(value)
        this.updateField(objField)
      },
      getItems(num) {
        return this.$store.getters[this.configProductSection.upLinks.find(item => item.column === num).module + '/items']
      },
      async onSave() {
        let isValid = await this.$validator.validate()
        if (!isValid) {
          return
        }
        this.save(Object.assign({}, this.product, this.editedItem, this.form)).then(response => this.saveProductSection(this.productSection))
      },
    }
  }
</script>
