<template>
  <div>
    <carousel name="carousel" :style="{ height: '428px'}" :pagination-enabled=false :navigation-enabled=true
              :per-page=perpage :per-page-custom="perCustom">
      <slide v-for="item in items" :key="item.id">
        <div class="special-product-wrapper">
          <div class="special-product text-xs-center" align="center">
            <div class="special-product__header text-xs-center">
              <a :href="getUrl(item)">{{item.title.length>52?item.title.substr(0,50)+'...':item.title}}</a>
            </div>
            <div class="special-product__img">
              <v-layout aligin-center row wrap>
                <a href="#" class="img-shadow">
                  <template v-if="getImages(item).length > 0">
                    <img :src="'/storage/'+getImages(product)[0].config.files.medium.filename"/>
                  </template>
                  <template v-else>
                    <img src="/images/no-image-medium.png"/>
                  </template>
                </a>
              </v-layout>
            </div>
            <div class="special-product__desc text-xs-center">Сделан на заказ</div>
            <v-layout col wrap class="special-product__mcart">
              <v-flex xs8 class="special-product__price text-xs-center">
                <!--<span class="old-price">145 800</span> руб.<br>-->
                <span class="current-price">{{Math.floor(item.price)}}</span> <span class="rub">руб.</span>
              </v-flex>
              <v-flex xs4 class="special-product__cart">
                <img @click="addCart(item.id)" src="/images/product-cart.png"/>
              </v-flex>
            </v-layout>
          </div>
        </div>
      </slide>
    </carousel>
  </div>
</template>
<script>
  import {Carousel, Slide} from 'vue-carousel';
  import {mapActions, mapMutations} from 'vuex'
  import {ACTIONS, MUTATIONS} from '@cart/constants'
  import axios from 'axios'

  export default {
    props: {
      url: String,
      perpage: {
        type: Number,
        default: 3
      },
      perCustom: Array
    },
    data: function () {
      return {
        items: [],
      }
    },
    created() {
      axios.get(this.url).then(response => {
        this.items = response.data
      }).catch((error) => {
        console.log(error);
      });
    },
    methods: {
      getUrl(item) {
        let url = '/catalog/detail/'
        url = url + item.url_key
        return url
      },
      addCart(id) {
        const count = 1
        this.addCartItem({id, count})
        this.showCartModal()
      },
      getImage(files) {
        if (files.length > 0) {
          return '/storage/' + files[0].config.files.medium.filename
        }
        else {
          return '/images/no-image-medium.png'
        }
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
        return _.shuffle(files)
      },
      ...mapActions('cart', {addCartItem: ACTIONS.ADD_CART}),
      ...mapMutations('cart', {showCartModal: MUTATIONS.SHOW_MODAL})
    },
    components: {
      Carousel,
      Slide
    }
  }
</script>

<style>
  /* Добавление размытия по-краям */
  .img-shadow {
    position: relative;
    margin: 0 auto;
    max-width: 100%;
    float: left;
  }

  .img-shadow::before {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    box-shadow: 0 0 8px 8px white inset;
    -moz-box-shadow: 0 0 8px 8px white inset;
    -webkit-box-shadow: 0 0 8px 8px white inset;
  }

  .img-shadow img {
    float: left;
  }

  /* Конец добавления размытия по-краям */
</style>