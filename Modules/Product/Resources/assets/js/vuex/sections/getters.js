export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.load="/products/sections"
    obj.module="sections"
    obj.primary_key="id"
    obj.model="Modules\\Product\\Entities\\Section"
    obj.upLinks=state.relations
    return obj
  },
  items: state => state.items,
  allowedLineProductsIds: state => {
    return (state.items.find(item => item.id === state.section) || []).LineProductIds || []
  }
}