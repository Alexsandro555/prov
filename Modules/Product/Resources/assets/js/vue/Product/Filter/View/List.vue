<template>
  <v-container px-2>
    <v-layout row wrap v-if="products.length>0">
      <div class="list-product-wrapper" v-for="product in paginatedProducts" :key="product.id">
        <v-container fill-height>
          <v-layout row wrap justify-center>
            <v-flex hidden-md-and-down xs4>
              <v-layout row wrap align-left justify-center>
                <div class="list-product__image" @click="goPage('/catalog/detail/'+product.url_key)">
                  <template v-if="getImages(product).length > 0">
                    <img :src="'/storage/'+getImages(product)[0].config.files.medium.filename"/>
                  </template>
                  <template v-else>
                    <img src="/images/no-image-medium.png"/>
                  </template>
                </div>
              </v-layout>
            </v-flex>
            <v-flex xs12 md8>
              <span class="list-product__title">
                <a :href="'/catalog/detail/'+product.url_key">{{ product.product_category.title_element }}<br>{{product.title}}</a>
                <v-divider width="400"></v-divider>
                <v-layout row wrap>
                  <v-flex md6 xs12>
                    <div class="list-product__attributes">
                        <dl class="list-product__attribute tabs__characteristics-attributes">
                          <template v-for="attribute in product.attributes">
                             <dt>{{attribute.title}}:</dt><dd class="tabs__characteristics--value">{{getAttributeValue(attribute.id, attribute.pivot.list_value)}}</dd>
                          </template>
                        </dl>
                    </div>
                  </v-flex>
                  <v-flex md6 xs12>
                    <template v-if="product.need_order">
                        <span><a class="product__need-order-link" onclick="ym(56003506,'reachGoal','requestPrice74951233321'); gtag('event', 'click', {'event_category': 'requestPrice','event_label': 'request price','value': 5}); return true;" @click="$root.discoverDiscount(`Добрый день! \nПрошу сообщить стоимость и наличие ${product.title}. \nСпасибо!`)"  href="#">Заказать</a></span>
                        <img onclick="ym(56003506,'reachGoal','requestPrice74951233321'); gtag('event', 'click', {'event_category': 'requestPrice','event_label': 'request price','value': 5}); return true;" @click="$root.discoverDiscount(`Добрый день! \nПрошу сообщить стоимость и наличие ${product.title}. \nСпасибо!`)" src="/images/btn-order.png" align="center"/>
                    </template>
                    <template v-else>
                      <p>
                        <span class="product-price-wrapper"><span class="product-price">{{product.price}}</span> руб.</span> <img onclick="ym(56003506,'reachGoal','cartClick74951233321'); gtag('event', 'click', {'event_category': 'cart','event_label': 'cart click main page','value': 1}); return true;" @click.prevent="addCart(product.id)" src="/images/btn-sale.png" align="center"/>
                      </p>
                    </template>
                  </v-flex>
                </v-layout>

              </span>
            </v-flex>
          </v-layout>
        </v-container>
      </div>
    </v-layout>
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
      },
      attributes: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
        page: 1,
        perPage: 10,
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
      },
      getAttributeValue(id, value) {
        let attribute = this.attributes.find(item => item.id == id)
        if(!attribute) return ''
        if (attribute.attribute_list_value.length > 0) {
          let result = attribute.attribute_list_value.find(item => item.id == value)
          return result?result.title:''
        } else {
          return ''
        }
      }
    }
  }
</script>

<style scoped lang="scss">
  .list-product-wrapper {
    width: 100%;
    height: 200px;
    margin: 20px 0px;
    background-color: #ecf6fc;
    clip-path: polygon(0% 0%, 97% 0%, 100% 50%, 97% 100%,  0% 100%);
  }
  .list-product__title {
    font-weight: bold;
    padding-bottom: 10px;
    font-size: 1.4em;
  }
  .list-product__image {
    background-color: #fff;
  }
  .list-product__attributes {
    padding-top: 10px;
  }
  .list-product__attribute {
    font-size: 0.7em;
  }
  .list-product__title a {
    text-decoration: none;
    color: #29435c;
  }
</style>