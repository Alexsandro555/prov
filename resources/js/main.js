import './bootstrap'

//===========Vue===========================================
import Vue from 'vue'
window.Vue = Vue
//===========Конец Vue=====================================

//===========Vuex==========================================
import Vuex from 'vuex'
import { mapActions, mapMutations, mapState } from 'vuex'
import {ACTIONS, MUTATIONS} from '@cart/constants'
import {ACTIONS as PRODUCT_ACTIONS} from '@product/constants'
import mutations from "./vuex/mutations";
import getters from "./vuex/getters";
Vue.use(Vuex)
//==========Конец Vuex=====================================

//==========Vuetify========================================
import Vuetify from 'vuetify'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)
//=========Конец Vuetify===================================

//=========Global components========================================
import LeftMenu from '@product/vue/Menu/LeftMenu'
Vue.component('left-menu', LeftMenu)
import DetailImage from '@file/vue/DetailImage'
Vue.component('detail-image', DetailImage)
import CartWidget from '@cart/vue/Widget'
Vue.component('cart-widget',CartWidget)
import CartModal from '@cart/vue/CartModal'
Vue.component('cart-modal', CartModal)
import CartPage from '@cart/vue/Cart'
Vue.component('cart-page', CartPage)
import Callback from '@callback/vue/callbacks/Callback.vue'
Vue.component('callback', Callback)
import FilterProducts from '@product/vue/Product/FilterProducts'
Vue.component('filter-products', FilterProducts)
import NamvigationMenu  from '@/vue/NavigationMenu.vue'
Vue.component('navigation-menu', NamvigationMenu)
import LeaderSlider from '@/components/Slider.vue'
Vue.component('leader-slider', LeaderSlider)
import CalculatePrice from '@product/vue/Product/CalculatePrice'
Vue.component('calculate-price', CalculatePrice)
import ProductOrder from '@product/vue/Product/ProductOrder'
Vue.component('product-order', ProductOrder)
import OrderForm from '@order/vue/OrderForm'
Vue.component('order-form', OrderForm)
//=========Конец Global components=================================


//========State=====================================================
import cart from '@cart/vuex/store'
import left_menu from '@product/vuex/left_menu/state'
import callback from '@callback/vuex/callbacks/state'
import initializer from '@initializer/vuex/initializer/state'
import sliderFullPage from '@/vuex/slider-full-page/state'
import sections from '@product/vuex/sections/state'
const store = new Vuex.Store({
  modules: {
    cart,
    callback,
    sliderFullPage,
    initializer,
    left_menu,
    sections
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
  },
  created() {
    store.dispatch('initializer/init')
    this.loadSections()
  },
  computed: {
    ...mapState('sections', ['section']),
    chickens() {
      return this.$store.state.sliderFullPage.slides.chickens
    },
    cows() {
      return this.$store.state.sliderFullPage.slides.cows
    },
    pigs() {
      return this.$store.state.sliderFullPage.slides.pigs
    },
    rams() {
      return this.$store.state.sliderFullPage.slides.rams
    },
    main() {
      return this.$store.state.sliderFullPage.slides.main
    },
  },
  store,
  methods: {
    goToPage(url) {
      window.location.href=url
    },
    addCart(id) {
      const count = 1
      this.addCartItem({id, count})
      this.showCartModal()
    },
    changeSlide(val) {
      switch (val) {
        case 'chickens':
          this.setVariableLeftMenu(1)
          break
        case 'cows':
          this.setVariableLeftMenu(2)
          break
        case 'pigs':
          this.setVariableLeftMenu(3)
          break
        case 'rams':
          this.setVariableLeftMenu(4)
          break
        default:
          this.setVariableLeftMenu(0)
          break
      }
      this.$store.dispatch('sliderFullPage/change',val)
    },
    setVariableLeftMenu(val) {
      this.$store.commit('SET_VARIABLE', {module: 'sections', variable: 'section', value: val})
      localStorage.setItem('section', val)
      window.location.href='/'
    },
    search(event) {
      const text = event.target.value.replace('/','_')
      window.location.href='/find/'+ text
      this.searchText = ''
    },
    showCallback() {
      this.$store.commit('SET_VARIABLE', {module: 'callback', variable: 'isVisible', value: true})
    },
    discoverDiscount(commentText='') {
      this.$store.commit('SET_VARIABLE', {module: 'callback', variable: 'isVisible', value: true})
      this.$store.commit('SET_VARIABLE', {module: 'callback', variable: 'form.comment', value: commentText})
    },
    ...mapActions('cart',{addCartItem: ACTIONS.ADD_CART}),
    ...mapMutations('cart', {showCartModal: MUTATIONS.SHOW_MODAL}),
    ...mapActions('sections', {loadSections: PRODUCT_ACTIONS.LOAD_SECTIONS})
  }
})