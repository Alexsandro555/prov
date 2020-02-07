export default {
	config: (state, getters, rootState, rootGetters) => {
    let obj=new Object()
    obj.items='items'
    obj.load='/api/articles'
    obj.loading = 'isLoading'
    obj.module='articles'
    obj.load_all = true
    obj.primary_key='id'
    obj.type_files = ['image-product']
    obj.model='Modules\\Article\\Models\\Article'
    obj.upLinks=state.up
    obj.downLinks=state.down
    return obj
	},
  items: state => state.items
}
