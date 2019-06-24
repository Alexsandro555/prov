<template>
  <div>
    <v-flex xs10 v-if="product.sku && getAttributes.length > 0">
      <v-select v-for="attribute in getAttributes"
                :key="attribute.id"
                height="35px"
                color="black"
                dark
                :name="attribute.id+'_id'"
                :label="attribute.title"
                :items="attribute.attribute_list_value"
                item-text="title"
                item-value="title"
                no-data-text="Нет данных"
                v-model="attributesValue[attribute.title]">
      </v-select>
    </v-flex>
    <a @click="formCallback()" class="product-order-req yellow darken-1" href="#">Запросить цену</a>
  </div>
</template>
<script>
  export default {
    props: {
      product: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        attributesValue: {},
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
        return this.getProductCategoryAttributes.concat(this.getTypeProductAttributes).concat(this.getLineProductAttributes)
      },
    },
    methods: {
      formCallback() {
        let commentText = 'Добрый день! \nПрошу сообщить стоимость и наличие товара:\n'+this.product.title
        for(let key in this.attributesValue) {
          commentText = commentText+'\n'+key+':'+this.attributesValue[key]
        }
        commentText = commentText+'\nСпасибо!'
        this.$store.commit('SET_VARIABLE', {module: 'callback', variable: 'isVisible', value: true})
        this.$store.commit('SET_VARIABLE', {module: 'callback', variable: 'form.comment', value: commentText})
      },
    }
  }
</script>
