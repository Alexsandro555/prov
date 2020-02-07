export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.loading = 'isLoading'
    obj.load="/api/news"
    obj.module="news"
    obj.load_all = true
    obj.primary_key="id"
    obj.type_files = ['image-product']
    obj.model="Modules\\News\\Entities\\News"
    obj.upLinks=state.up
    obj.downLinks=state.down
    return obj
  },
  items: state => state.items
}