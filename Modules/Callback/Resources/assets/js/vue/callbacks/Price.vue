<template>
  <div>
    <v-container no-gutter class="ma-0 pa-3">
      <v-row>
        <v-col cols="12">
          <v-select
            v-for="attribute in getAttributes"
            :key="attribute.id"
            height="35px"
            :name="attribute.id+'_id'"
            :label="attribute.title"
            :items="sorting(attribute.attribute_list_value)"
            item-text="title"
            item-value="id"
            no-data-text="Нет данных"
            v-model="attributesValue[attribute.id]">
          </v-select>
          <a
            onclick="ym(54321909,'reachGoal','requestPrice74951233321'); gtag('event', 'click', {'event_category': 'requestPrice','event_label': 'request price detail page','value': 5}); return true;"
            @click="formCallback()"
            class="product-order-req"
            href="#">
            Запросить цену
          </a>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
  export default {
    name: 'CallbackPrice',
    props: {
      product: {
        type: Object,
        required: true
      }
    },
    computed: {
      getProductCategoryAttributes() {
        return (this.product.product_category && this.product.product_category.attributes) || []
      },
      getTypeProductAttributes() {
        return (this.product.type_product && this.product.type_product.attributes) || []
      },
      getLineProductAttributes() {
        return (this.product.line_product && this.product.line_product.attributes) || []
      },
      getAttributes() {
        return _.orderBy(this.getProductCategoryAttributes.concat(this.getTypeProductAttributes).concat(this.getLineProductAttributes), ['sort'], ['asc'])
      }
    },
    data() {
      return {
        attributesValue: {},
        allElements: {}
      }
    },
    created() {
      this.allElements = Object.assign({}, ...this.getAttributes.map(attribute => ({
        [attribute.id]: attribute
      })));
      this.getAttributes.forEach(attribute => {
        if (attribute.attribute_list_value.length > 0) {
          let obj = {};
          obj[attribute.id] = (attribute.attribute_list_value.find(item => item.default === 1) || []).id
          this.attributesValue = Object.assign({}, this.attributesValue, obj)
        }
      })
    },
    methods: {
      sorting(items) {
        return _.orderBy(items, ['sort'], ['asc'])
      },
      formCallback() {
        let commentText = 'Добрый день! \nПрошу сообщить стоимость и наличие товара:\n' + this.product.title
        for (let key in this.attributesValue) {
          if (this.attributesValue[key] === undefined) continue;
          commentText = commentText + '\n' + this.allElements[key].title + ': ' + this.allElements[key].attribute_list_value.find(item => item.id === this.attributesValue[key]).title
        }
        commentText = commentText + '\nСпасибо!'
        this.$store.commit('SET_VARIABLE_MODULE', {module: 'callback', variable: 'isVisible', value: true})
        this.$store.commit('SET_VARIABLE_MODULE', {module: 'callback', variable: 'form.comment', value: commentText})
      }
    }
  }
</script>

<style scoped>
  .product-order-req {
    color: #346e1d !important;
  }
</style>