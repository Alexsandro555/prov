export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.load="/api/type_products"
    obj.loading = 'isLoading'
    obj.module="type_products"
    obj.primary_key="id"
    obj.type_files = ['image-product']
    obj.model="Modules\\Product\\Entities\\TypeProduct"
    obj.upLinks=state.up
    obj.downLinks=state.down
    return obj
  },
  items: state => state.items,
  primary_key: getters => (_.isEmpty(getters.config))?'id':(!_.isEmpty(getters.config.primary_key))?getters.config.primary_key:'id',
}