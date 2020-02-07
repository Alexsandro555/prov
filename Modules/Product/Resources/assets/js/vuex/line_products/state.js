import module_actions from './actions.js'
import standart_actions from '@/vuex/actions.js'
import module_mutations from './mutations.js'
import standart_mutations from '@/vuex/mutations.js'
import module_getters from './getters.js'
import standart_getters from '@/vuex/getters'
import items from './items.js'
import fields from './fields.js'
import rules from './rules.js'
import relationships from './relationships'

var actions = Object.assign({}, module_actions, standart_actions)
var getters = Object.assign({}, module_getters, standart_getters)
var mutations = Object.assign({}, module_mutations, standart_mutations)

const state = {
  name: 'LineProduct',
  items,
  formFields: fields,
  up: [{column: 'type_product_id', module: 'type_products'}],
  down: [{column: 'product_id', module: 'products'}],
  rules,
  isLoading: false,
  isSaving: false,
  colTableFields: 4,
  count: null
}

const module = {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}

export default module;

