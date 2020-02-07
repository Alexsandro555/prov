import {GETTERS} from '@product/constants'

export default {
  config: (state) => {
    let obj = new Object()
    obj.items = "items"
    obj.loading = 'isLoading'
    obj.load = "/api/attribute_values"
    obj.module = "attribute_values"
    obj.primary_key = "id"
    obj.model = "Modules\\Product\\Entities\\AttributeValues"
    obj.upLinks=state.up
    obj.downLinks=state.down
    return obj
  },
  items: state => state.items,
  primary_key: getters => (_.isEmpty(getters.config))?'id':(!_.isEmpty(getters.config.primary_key))?getters.config.primary_key:'id',
}