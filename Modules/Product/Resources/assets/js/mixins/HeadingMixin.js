import {mapState} from 'vuex'

export default {
  data() {
    return {
      form: {
        product_category_id: null,
        type_product_id: null,
        line_product_id: null
      }
    }
  },
  computed: {
    getTypeProducts() {
      return _.sortBy(this.typeProducts.filter(item => item.product_category_id == this.form.product_category_id),[function(o) {return o.sort}])
    },
    // список линеек продуктов для выбранного типа продукта
    getLineProducts() {
      return _.sortBy(this.lineProducts.filter(item => item.type_product_id == this.form.type_product_id),[function(o) {return o.sort}])
    },
    getProductCategories() {
      return _.sortBy(this.productCategories,[function(o) {return o.sort}])
    },
    getProductCategory() {
      return this.productCategories.find(item => item.id == this.form.product_category_id)
    },
    ...mapState('product_categories', {productCategories: 'items'}),
    ...mapState('type_products', {typeProducts: 'items'}),
    ...mapState('line_products', {lineProducts: 'items'}),
  },
  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.loadHeading()
    })
  },
  methods: {
    changeProductCategories() {
      this.form.type_product_id = null
      this.form.line_product_id = null
    },
    changeTypeProducts() {
      this.form.line_product_id = null
    },
    loadHeading() {
      let actionPromise = [];
      ['product_categories', 'type_products', 'line_products'].forEach(action => {
        actionPromise[action] = this.$store.dispatch(action + '/GLOBAL_LOAD_ALL')
      })
      Promise.all(actionPromise)
    },
  }
}