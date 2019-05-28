export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.load="/api/files"
    obj.module="files"
    obj.primary_key="id"
    obj.model="Modules\\Files\\Entities\\File"
    obj.upLinks=state.relations
    return obj
  },
  items: state => state.items
}