export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.load="/api/files"
    obj.loading = 'isLoading'
    obj.module="files"
    obj.primary_key="id"
    obj.model="Modules\\Files\\Entities\\File"
    obj.upLinks=state.up
    obj.downLinks=state.down
    return obj
  },
  items: state => state.items,
  primary_key: getters => (_.isEmpty(getters.config))?'id':(!_.isEmpty(getters.config.primary_key))?getters.config.primary_key:'id',
}