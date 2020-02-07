export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.load="/api/tnveds"
    obj.loading = 'isLoading'
    obj.module="tnveds"
    obj.primary_key="id"
    obj.load_all = true
    obj.model="Modules\\Product\\Entities\\Tnved"
    obj.upLinks=state.up
    obj.downLinks=state.down
    return obj
  },
  items: state => state.items,
  primary_key: getters => (_.isEmpty(getters.config))?'id':(!_.isEmpty(getters.config.primary_key))?getters.config.primary_key:'id',
}