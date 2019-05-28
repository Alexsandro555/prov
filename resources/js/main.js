import './bootstrap'

import Vue from 'vue'
window.Vue = Vue

//===========Vuex==========================================
import Vuex from 'vuex'
Vue.use(Vuex)

//==========Vuetify========================================
import Vuetify from 'vuetify'
// Импорт CSS-файлов, которые могут потребоваться
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import 'vuetify/dist/vuetify.min.css'
import createStore from "./vuex/states";
Vue.use(Vuetify)

import LeftMenu from '@/components/menu/LeftMenu'
Vue.component('left-menu', LeftMenu)

import DetailImage from '@file/vue/DetailImage'
Vue.component('detail-image', DetailImage)

import { mapActions, mapMutations } from 'vuex'
import {ACTIONS, MUTATIONS} from '@cart/constants'

import CartWidget from '@cart/vue/Widget'
import mutations from "./vuex/mutations";
import getters from "./vuex/getters";
Vue.component('cart-widget',CartWidget)

import CartModal from '@cart/vue/CartModal'
Vue.component('cart-modal', CartModal)

import CartPage from '@cart/vue/Cart'
Vue.component('cart-page', CartPage)

// Обратный звонок
import Callback from '@callback/vue/callbacks/Callback.vue'
import callback from '@callback/vuex/callbacks/state'
Vue.component('callback', Callback)

import sliderFullPage from '@/vuex/slider-full-page/state'

import cart from '@cart/vuex/store'
const store = new Vuex.Store({
  modules: {
    cart,
    callback,
    sliderFullPage
  },
  mutations,
  getters
  }
)

import FilterProducts from '@/components/FilterProducts'
Vue.component('filter-products', FilterProducts)
import NamvigationMenu  from '@/vue/NavigationMenu.vue'
Vue.component('navigation-menu', NamvigationMenu)
import LeaderSlider from '@/components/Slider.vue'
Vue.component('leader-slider', LeaderSlider);

const app = new Vue({
  el: '#app',
  data: {
    searchText: '',
  },
  computed: {
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
      this.$store.dispatch('sliderFullPage/change',val)
    },
    search(event) {
      const text = event.target.value.replace('/','_')
      window.location.href='/find/'+ text
      this.searchText = ''
    },
    showCallback() {
      this.$store.commit('SET_VARIABLE', {module: 'callback', variable: 'isVisible', value: true})
    },
    ...mapActions('cart',{addCartItem: ACTIONS.ADD_CART}),
    ...mapMutations('cart', {showCartModal: MUTATIONS.SHOW_MODAL})
  }
})