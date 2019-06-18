<template>
  <v-container>
      <v-layout row wrap>
        <v-flex xs10 v-if="attributes.length > 0">
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
              <template v-for="product in getPagesElement">
                <slot :product="product" :getImages="getImages" :addCart="addCart" :getUrl="getUrl"></slot>
              </template>
            </v-layout>
            <div v-else>
              <h2 class="not-found-product">Продукция с заданными параметрами не найдена</h2>
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
        default: () => []
      },
      attributes: {
        type: Array,
        default: () => []
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
      getUrl(item) {
        let url = '/catalog/detail/'
        url = url + item.url_key
        return url
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