export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.load="/api/product_categories"
    obj.loading = 'isLoading'
    obj.module="product_categories"
    obj.primary_key="id"
    obj.load_all = true
    obj.type_files = ['image-product']
    obj.model="Modules\\Product\\Entities\\ProductCategory"
    //obj.upLinks=state.relationships.filter(relationship => relationship.type === 'BelongsTo').map(relationship => {return {'column': relationship.foreignKey, 'module': relationship.table}})
    //obj.downLinks=state.relationships.filter(relationship => relationship.type === 'HasMany').map(relationship => {return {'column': relationship.foreignKey, 'module': relationship.table}})
    return obj
  },
  items: state => state.items,
  primary_key: getters => (_.isEmpty(getters.config))?'id':(!_.isEmpty(getters.config.primary_key))?getters.config.primary_key:'id',
}

