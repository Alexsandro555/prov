import './bootstrap'

import store from './vuex/states.js'

//=================роутинг==============================
import VueRouter from 'vue-router'
import routes from './routes'
Vue.use(VueRouter)
const router = new VueRouter({routes})
//===============конец роутинга=========================

//=================socket===============================
import socketio from 'socket.io-client'
import VueSocketio from 'vue-socket.io'
Vue.use(new VueSocketio({
  debug: true,
  connection: socketio(window.location.hostname+':8081', {secure: false}),
  vuex: {
    store,
    actionPrefix: "socket_",
    mutationPrefix: "socket_"
  }
}))
//===============конец socket===========================

import vuetify from './vuetify'

import '@app/global'
import '@file/global'
import '@initializer/global'
import Notifications from '@/vue/Notifications.vue'
Vue.component('notifications', Notifications)

const app = new Vue({
  el: '#admin',
  router,
  store,
  vuetify,
  created() {
    store.dispatch('initializer/init')
  }
});
