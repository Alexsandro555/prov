<template>
  <div>
    <carousel name="carousel"
              :style="{ height: '428px'}"
              :pagination-enabled=false
              :navigation-enabled=true
              navigationNextLabel = '<img src="/images/slider-right-arrow.png" class="slider-right-arrow">'
              navigationPrevLabel = '<img src="/images/slider-left-arrow.png" class="slider-left-arrow">'
              :per-page=perpage
              :per-page-custom="perCustom">
      <slide v-for="item in items" :key="item.id">
          <slot :product="item" :getImages="getImages" :addCart="addCart" :getUrl="getUrl"></slot>
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

  .slider-left-arrow {
    margin-right: -40px;
  }

  .slider-right-arrow {
    margin-left: -75px;
  }

  /* Конец добавления размытия по-краям */
</style>