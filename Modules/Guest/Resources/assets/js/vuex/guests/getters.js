export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.load="/api/guests"
    obj.module="guests"
    obj.primary_key="id"
    obj.model="Modules\\Guest\\Entities\\Guest"
    obj.upLinks=state.relations
    return obj
  },
  items: state => state.items
}