export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.load="/api/line_products"
    obj.loading = 'isLoading'
    obj.module="line_products"
    obj.primary_key="id"
    obj.type_files = ['image-product']
    obj.model="Modules\\Product\\Entities\\LineProduct"
    obj.upLinks=state.up
    obj.downLinks=state.down
    return obj
  },
  items: state => state.items,
  primary_key: getters => (_.isEmpty(getters.config))?'id':(!_.isEmpty(getters.config.primary_key))?getters.config.primary_key:'id',
}