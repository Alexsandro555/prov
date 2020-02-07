import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
import * as actions from './actions'
import mutations from './mutations'
import getters from './getters'
import searchModules from './searchModules'

let modules = {
  ...searchModules
}

export default new Vuex.Store({
    modules,
    mutations,
    getters
  }
)