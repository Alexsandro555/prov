<template>
  <v-container px-0>
    <v-layout row wrap v-if="products.length>0">
      <div class="product-wrapper" v-for="product in paginatedProducts">
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
              {{ product.product_category.title_element }}<br>{{product.title.substr(0, 42)}}
            </a>
          </div>
          <v-layout row wrap>
            <template v-if="product.need_order">
              <v-flex xs8 text-xs-center>
                <span><a class="product__need-order-link" onclick="ym(56003506,'reachGoal','requestPrice74951233321'); gtag('event', 'click', {'event_category': 'requestPrice','event_label': 'request price','value': 5}); return true;" @click="$root.discoverDiscount(`Добрый день! \nПрошу сообщить стоимость и наличие ${product.title}. \nСпасибо!`)"  href="#">Необходимо заказывать</a></span>
              </v-flex>
              <v-flex xs4>
                <img onclick="ym(56003506,'reachGoal','requestPrice74951233321'); gtag('event', 'click', {'event_category': 'requestPrice','event_label': 'request price','value': 5}); return true;" @click="$root.discoverDiscount(`Добрый день! \nПрошу сообщить стоимость и наличие ${product.title}. \nСпасибо!`)" src="/images/btn-order.png"/>
              </v-flex>
            </template>
            <template v-else>
              <v-flex xs8 text-xs-center>
                <br>
                <span class="product-price-wrapper">
                    <span class="product-price">{{product.price}}</span> руб.</span>
              </v-flex>
              <v-flex xs4>
                <img onclick="ym(56003506,'reachGoal','cartClick74951233321'); gtag('event', 'click', {'event_category': 'cart','event_label': 'cart click main page','value': 1}); return true;" @click="addCart(product.id)" src="/images/btn-sale.png"/>
              </v-flex>
            </template>
          </v-layout>
        </div>
      </div>
    </v-layout>
    <div v-else>
      <h2>Продукция с заданными параметрами не была найдена</h2>
    </div>
    <v-flex xs12 text-xs-center>
      <v-pagination v-if="colPages > 1" :total-visible="6" v-model="page" :page="page" :length="colPages"></v-pagination>
    </v-flex>
  </v-container>
</template>
<script>
  import vuex from 'vuex'
  import { mapActions, mapMutations } from 'vuex'
  import {ACTIONS, MUTATIONS} from '@cart/constants'

  export default {
    props: {
      products: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
        page: 1,
        perPage: 15,
      }
    },
    computed: {
      colPages() {
        return Math.floor(this.products.length/this.perPage)+1
      },
      paginatedProducts() {
        return _.slice(this.products,(this.page-1)*this.perPage,(this.page-1)*this.perPage+this.perPage)
      }
    },
    watch: {
      products(values) {
        this.page = 1
      }
    },
    methods: {
      ...mapActions('cart',{addCartItem: ACTIONS.ADD_CART}),
      ...mapMutations('cart', {showCartModal: MUTATIONS.SHOW_MODAL}),
      addCart(id) {
        const count = 1
        this.addCartItem({id, count})
        this.showCartModal()
      },
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
        files = files.filter(item => item.image_view_id == product.image_view_id || _.isNull(item.image_view_id))
        return _.shuffle(files)
      },
      goPage(url) {
        window.location.href=url
      }
    }
  }
</script>

<style scoped>
  .product-wrapper {
    margin: 25px;
  }
</style>