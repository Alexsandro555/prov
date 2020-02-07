export default {
  config: (state, getters, rootState, rootGetters) => {
    let obj = new Object()
    obj.items = 'items'
    obj.load = '/api/callbacks'
    obj.module = "callbacks"
    obj.loading = 'isLoading'
    obj.primary_key = 'id'
    obj.model = 'Modules\\Callback\\Models\\Callback'
    obj.upLinks = state.up
    obj.downLinks = state.down
    return obj
  },
  items: state => state.items,
  primary_key: getters => (_.isEmpty(getters.config))?'id':(!_.isEmpty(getters.config.primary_key))?getters.config.primary_key:'id'
}
