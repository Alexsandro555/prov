export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.load="/api/guest_pages"
    obj.module="guest_pages"
    obj.primary_key="id"
    obj.model="Modules\\Guest\\Entities\\GuestPages"
    obj.upLinks=state.relations
    return obj
  },
  items: state => state.items
}