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
                item-value="id"
                no-data-text="Нет данных"
                v-model="attributesValue[attribute.id]">
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
        allElements: {}
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
      }
    },
    created() {
      this.getAttributes.forEach(item => {
        let arr = []
        arr.push(item)
        this.allElements[item.id] = arr
      })
      this.getAttributes.forEach(attribute => {
        if(attribute.attribute_list_value.length > 0) {
          let obj = {};
          obj[attribute.id] = (attribute.attribute_list_value.find(item => item.default === 1) || []).id
          this.attributesValue = Object.assign({}, this.attributesValue, obj)
        }
      })
    },
    methods: {
      formCallback() {
        let commentText = 'Добрый день! \nПрошу сообщить стоимость и наличие товара:\n'+this.product.title
        let that = this
        for(let key in this.attributesValue) {
          if(this.attributesValue[key] === undefined) break;
          commentText = commentText+'\n'+that.allElements[key].find(item => item.id == key).title+': '+that.allElements[key].find(item => item.id == key).attribute_list_value.find(item => item.id === that.attributesValue[key]).title
        }
        commentText = commentText+'\nСпасибо!'
        this.$store.commit('SET_VARIABLE', {module: 'callback', variable: 'isVisible', value: true})
        this.$store.commit('SET_VARIABLE', {module: 'callback', variable: 'form.comment', value: commentText})
      },
    }
  }
</script>
