export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.load="/api/attribute_units"
    obj.loading = 'isLoading'
    obj.module="attribute_units"
    obj.load_all = true
    obj.primary_key="id"
    obj.model="Modules\\Product\\Entities\\AttributeUnit"
    obj.upLinks=state.up
    obj.downLinks=state.down
    return obj
  },
  items: state => state.items,
  primary_key: getters => (_.isEmpty(getters.config))?'id':(!_.isEmpty(getters.config.primary_key))?getters.config.primary_key:'id',
}