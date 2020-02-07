import module_actions from './actions.js'
import standart_actions from '@/vuex/actions.js'
import module_mutations from './mutations.js'
import standart_mutations from '@/vuex/mutations.js'
import module_getters from './getters.js'
import standart_getters from '@/vuex/getters'

var actions=Object.assign({}, module_actions, standart_actions)
var getters=Object.assign({}, module_getters, standart_getters)
var mutations = Object.assign({}, module_mutations, standart_mutations)

import image_1 from '@app/../images/sidebar-1.23832d31.jpg'
import image_2 from '@app/../images/sidebar-2.32103624.jpg'
import image_3 from '@app/../images/sidebar-3.3a54f533.jpg'
import image_4 from '@app/../images/sidebar-4.3b7e38ed.jpg'

const state = {
  name: 'App',
  drawer: null,
  color: 'warning',
  image: localStorage.getItem('image') || image_1
}

const module = {
  namespaced:true,
  state,
  getters,
  mutations,
  actions
}

export default module;