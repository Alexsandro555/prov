import module_actions from './actions.js'
import standart_actions from '@/vuex/actions.js'
import module_mutations from './mutations.js'
import standart_mutations from '@/vuex/mutations.js'
import module_getters from './getters.js'
import standart_getters from '@/vuex/getters'

var actions = Object.assign({}, module_actions, standart_actions)
var getters = Object.assign({}, module_getters, standart_getters)
var mutations = Object.assign({}, module_mutations, standart_mutations)

const state = {
  name: 'MenuLeft',
  items: [],
  loading: true,
  section: 0,
  sections: [
    {
      id: 1,
      title: 'Птицеводство',
      sort: 1,
      line_products: [4]
    },
    {
      id: 2,
      title: 'Скотоводство',
      sort: 2,
      line_products: []
    },
    {
      id: 3,
      title: 'Свиноводство',
      sort: 3,
      line_products: []
    },
    {
      id: 4,
      title: 'Прочее',
      sort: 4,
      line_products: []
    }
  ]
}

const module = {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}

export default module;

