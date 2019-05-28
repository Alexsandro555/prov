<template>
  <v-container>
      <v-layout row wrap>
        <v-flex xs10>
          <v-container>
            <v-layout align-end justify-center fill-height col>
              <v-flex pa-2 v-for="attribute in attributes" :key="attribute.id">
                  <v-select
                    height="35px"
                    color="black"
                    light
                    :name="attribute.id+'_id'"
                    :label="attribute.title"
                    :items="attribute.attribute_list_value"
                    item-text="title"
                    item-value="id"
                    no-data-text="Нет данных"
                    :value="attribute.value"
                    @change="selectItem($event,attribute.id)"></v-select>
              </v-flex>
              <v-flex align-self-center><v-btn color="success" @click="reset">Сбросить</v-btn></v-flex>
            </v-layout>
          </v-container>
        </v-flex>
        <v-flex xs12>
          <v-layout column wrap>
            <v-layout row wrap v-if="filteredProducts.length>0">
              <div class="product-wrapper" v-for="product in getPagesElement">
              <div class="product">
                <div class="product-image-wrapper">
                  <div class="product-image" @click="goPage('/catalog/detail/'+product.url_key)">
                    <template v-if="getImages(product).length > 0">
                      <img :src="'/storage/'+getImages(product)[0].config.files.medium.filename"/>
                    </template>
                    <template v-else>
                      <img src="/images/no-image-medium.png"/>
                    </template>
                  </div>
                </div>
                <div class="product__title">
                  <a :href="'/catalog/detail/'+product.url_key">
                    {{product.title.substr(0, 27)+".."}}
                  </a>
                </div>
                <v-layout row wrap>
                  <v-flex xs8 text-xs-center>
                    <br>
                    <span class="product-price-wrapper">
                    <span class="product-price">{{product.price}}</span> руб.</span>
                  </v-flex>
                  <v-flex xs4>
                    <img @click="addCart(product.id)" src="/images/btn-sale.png"/>
                  </v-flex>
                </v-layout>
              </div>
            </div>
            </v-layout>
            <div v-else>
              <h2>Продукция с заданными параметрами не найдена</h2>
            </div>
            <div class="text-xs-center">
              <v-pagination v-if="colPages > 1" v-model="page" :length="colPages"></v-pagination>
            </div>
          </v-layout>
        </v-flex>
      </v-layout>
    </v-container>
</template>
<script>
  import { mapActions, mapMutations } from 'vuex'
  import {ACTIONS, MUTATIONS} from '@cart/constants'

  export default {
    props: {
      products: {
        type: Array,
        default: []
      },
      attributes: {
        type: Array,
        default: []
      }
    },
    data() {
      return {
        filteredProducts: this.products,
        filterAttributes: [],
        page: 1
      }
    },
    computed: {
      getPagesElement() {
        return _.slice(this.filteredProducts,(this.page-1)*16,this.page*16)
      },
      colPages() {
        return Math.floor(this.filteredProducts.length/16)+1
      },
    },
    methods: {
      getImages(product) {
        let files = []
        if(product.product_category && product.product_category.files.length > 0) {
          files = _.concat(files,product.product_category.files)
        }
        if(product.type_product && product.type_product.files.length > 0) {
          files = _.concat(files, product.type_product.files)
        }
        if(product.line_product && product.line_product.files.length > 0) {
          files = _.concat(files, product.line_product.files)
        }
        if(product.files.length > 0) {
          files = _.concat(files, product.files)
        }
        return _.shuffle(files)
      },
      goPage(url) {
        window.location.href=url
      },
      addCart(id) {
        const count = 1
        this.addCartItem({id, count})
        this.showCartModal()
      },
      selectItem(value,id) {
        this.page = 1
        Vue.set(this.attributes.find(attribute => attribute.id === id), 'value', value)
        //this.filterAttributes.$set(id, value)

        let filteredProducts = [...this.products]
        this.attributes.forEach(attributeFiltr => {
          if(attributeFiltr.value) {
            filteredProducts =  filteredProducts.filter(product => {
              return product.attributes.find(attribute => attribute.id === attributeFiltr.id && attribute.pivot.list_value === attributeFiltr.value)
            })
          }
        })
        this.filteredProducts = [...filteredProducts]
        /*let filteredProducts = [...this.products]
        this.attributes.forEach(attributeFiltered => {
          if(attributeFiltered.value) {
            filteredProducts = filteredProducts.filter(product => {
              return product.attributes.find(attribute => attribute.id === attributeFiltered.id && attribute.pivot.list_value === attributeFiltered.value)
            })
          }
        })
        this.filteredProducts = filteredProducts.filter(product => {
          return product.attributes.find(attribute => attribute.id === id && attribute.pivot.list_value === value)
        })
        Vue.set(this.attributes.find(attribute => attribute.id === id), 'value', value)*/
        /*this.filteredProducts = this.filteredProducts.filter(product => {
          return product.attributes.find(attribute => attribute.id === id && attribute.pivot.list_value === value)
        })*/
      },
      reset() {
        this.page = 1
        this.filteredProducts = this.products
        this.attributes.forEach(attribute => {
          attribute.value = null
        })
      },
      ...mapActions('cart',{addCartItem: ACTIONS.ADD_CART}),
      ...mapMutations('cart', {showCartModal: MUTATIONS.SHOW_MODAL})
    }

  }
</script>