export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.load="/left-menu"
    obj.module="left_menu"
    obj.primary_key="id"
    return obj
  },
  items: state => state.items,
  /*allowedLineProductsIds: state => {
    return (state.sections.find(item => item.id === state.section) || []).line_products || []
  }*/
}