export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.load="/api/attributables"
    obj.module="attributables"
    obj.loading = 'isLoading'
    obj.primary_key=["attributable_type", "attributable_id"]
    obj.model="Modules\\Product\\Entities\\Attributables"
    obj.upLinks=state.up
    obj.downLinks=state.down
    return obj
  },
  items: state => state.items,
  primary_key: getters => (_.isEmpty(getters.config))?'id':(!_.isEmpty(getters.config.primary_key))?getters.config.primary_key:'id',
}