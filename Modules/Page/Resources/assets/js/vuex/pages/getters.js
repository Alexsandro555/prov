export default {
	config: (state, getters, rootState, rootGetters) => {
    let obj=new Object()
    obj.items='items'
    obj.load='/api/pages'
    obj.loading = 'isLoading'
    obj.module='pages'
    obj.load_all = true
    obj.primary_key='id'
    obj.model='Modules\\Page\\Models\\Page'
    obj.upLinks=state.up
    obj.downLinks=state.down
    return obj
	},
  items: state => state.items
}
