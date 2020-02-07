export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.load="/api/product_section"
    obj.loading = 'isLoading'
    obj.module="product_section"
    obj.primary_key="product_id"
    obj.model="Modules\\Section\\Entities\\ProductSection"
    obj.upLinks=state.up
    obj.downLinks=state.down
    return obj
  },
  items: state => state.items,
  primary_key: getters => (_.isEmpty(getters.config))?'id':(!_.isEmpty(getters.config.primary_key))?getters.config.primary_key:'id',
}


