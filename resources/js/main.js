import './bootstrap'


//===========Vuex==========================================
import Vuex from 'vuex'
import {mapActions, mapMutations, mapState} from 'vuex'
import {ACTIONS, MUTATIONS} from '@cart/constants'
import {ACTIONS as PRODUCT_ACTIONS} from '@product/constants'
import mutations from "./vuex/mutations";
import getters from "./vuex/getters";

Vue.use(Vuex)
//==========Конец Vuex=====================================

//==========Vuetify========================================
import Vuetify from 'vuetify'

Vue.use(Vuetify)
//=========Конец Vuetify===================================

//=========Global components========================================
import LeftMenu from '@product/vue/Menu/LeftMenu'
Vue.component('left-menu', LeftMenu)

import DetailImage from '@file/vue/DetailImage'
Vue.component('detail-image', DetailImage)

import CartWidget from '@cart/vue/Widget'
Vue.component('cart-widget', CartWidget)

import CartModal from '@cart/vue/CartModal'
Vue.component('cart-modal', CartModal)

import CartPage from '@cart/vue/Cart'
Vue.component('cart-page', CartPage)

import Callback from '@callback/vue/callbacks/Callback.vue'
Vue.component('callback', Callback)

import FilterProducts from '@product/vue/Product/Filter'
Vue.component('filter-products', FilterProducts)

import NamvigationMenu from '@initializer/vue/NavigationMenu.vue'
Vue.component('navigation-menu', NamvigationMenu)

import LeaderSlider from '@/components/Slider.vue'
Vue.component('leader-slider', LeaderSlider)

import Carousel from '@product/vue/Product/Carousel'
Vue.component('carousel', Carousel)

import CalculatePrice from '@product/vue/Product/CalculatePrice'
Vue.component('calculate-price', CalculatePrice)

import ProductOrder from '@product/vue/Product/ProductOrder'
Vue.component('product-order', ProductOrder)

import OrderForm from '@order/vue/OrderForm'
Vue.component('order-form', OrderForm)

import SectionButtons from '@section/vue/Section/Buttons'
Vue.component('section-buttons', SectionButtons)

import NavigationMenuCategory from '@initializer/vue/NavigationMenuCategory'
Vue.component('navigation-menu-category', NavigationMenuCategory)

import CallbackPrice from '@callback/vue/callbacks/Price'
Vue.component('CallbackPrice', CallbackPrice)

//=========Конец Global components=================================

//========State=====================================================
import cart from '@cart/vuex/store'
import left_menu from '@product/vuex/left_menu/state'
import callback from '@callback/vuex/callbacks/state'
import initializer from '@initializer/vuex/initializer/state'
import sliderFullPage from '@/vuex/slider-full-page/state'
import sections from '@section/vuex/sections/state'

const store = new Vuex.Store({
    modules: {
      cart,
      sliderFullPage,
      initializer,
      left_menu,
      sections,
      callback
    },
    mutations,
    getters
  }
)
//======Конец State================================================

const app = new Vue({
  el: '#app',
  data: {
    searchText: '',
    drawer: false,
    drawer2: false,
  },
  vuetify: new Vuetify(
    {
      icons: {
        iconfont: 'md',
      },
      theme: {
        dark: false,
      },
      themes: {
        light: {
          primary: "#4682b4",
          secondary: "#b0bec5",
          accent: "#8c9eff",
          error: "#b71c1c",
        },
      },
    }
  ),
  computed: {
    ...mapState('sections', ['current']),
    getHeaderClass() {
      return {
        'birds': this.current == 1,
        'cows': this.current == 2,
        'pigs': this.current == 3,
        'others': this.current == 8,
        'main-layout': this.current == null,
      }
    }
  },
  store,
  methods: {
    ...mapActions('cart', {addCartItem: ACTIONS.ADD_CART}),
    ...mapMutations('cart', {showCartModal: MUTATIONS.SHOW_MODAL}),
    ...mapActions('sections', {loadSections: PRODUCT_ACTIONS.LOAD_SECTIONS}),
    open() {
      this.drawer = !this.drawer
    },
    openCatalog() {
      this.drawer2 = !this.drawer2
    },
    goToPage(url) {
      window.location.href = url
    },
    addCart(id) {
      const count = 1
      this.addCartItem({id, count})
      this.showCartModal()
    },
    setVariableLeftMenu(val) {
      this.$store.commit('SET_VARIABLE_MODULE', {module: 'sections', variable: 'section', value: val}, {root: true})
      localStorage.setItem('section', val)
      window.location.href = '/'
    },
    search(event) {
      const text = event.target.value.replace('/', '_')
      window.location.href = '/find/' + text
      this.searchText = ''
    },
    showCallback() {
      this.$store.commit('SET_VARIABLE_MODULE', {module: 'callback', variable: 'isVisible', value: true}, {root: true})
    },
    discoverDiscount(commentText = '') {
      this.$store.commit('SET_VARIABLE_MODULE', {module: 'callback', variable: 'isVisible', value: true}, {root: true})
      this.$store.commit('SET_VARIABLE_MODULE', {module: 'callback', variable: 'form.comment', value: commentText}, {root: true})
    },
  }
})