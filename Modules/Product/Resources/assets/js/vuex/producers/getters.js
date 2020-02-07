export default {
  config: (state) => {
    let obj = new Object()
    obj.items = "items"
    obj.load = "/api/producers"
    obj.loading = 'isLoading'
    obj.module = "producers"
    obj.load_all = true
    obj.primary_key = "id"
    obj.model = "Modules\\Product\\Entities\\Producer"
    obj.upLinks = state.up
    obj.downLinks=state.down
    return obj
  },
  items: state => state.items,
  primary_key: getters => (_.isEmpty(getters.config))?'id':(!_.isEmpty(getters.config.primary_key))?getters.config.primary_key:'id',
}