<template>
  <div>
    <p>
      <span class="detail__price">
          <span class="detail__price--big">{{getPrice?getPrice.price:product.price}}</span>
          ₽{{product.price_amount?'/'.product.price_amount:""}}
      </span><br>
      <v-chip v-if="product.vendor" color="yellow">арт. {{product.vendor}}</v-chip>
    </p>
    <div class="figure-button__wrapper">
      <a class="figure-button" @click="addCart(product.id)" href="#">
        Заказать
        <img src="/images/btn-sale-image.png" align="center"/>
      </a>
    </div>
    <v-flex xs10 v-if="product.line_product.attributes.length > 0">
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
    computed: {
      getAttributes() {
        return this.product.product_category.attributes.concat(this.product.type_product.attributes).concat(this.product.line_product.attributes)
      },
      getPrice() {
        return !this.product.sku?this.product.price:this.product.prices.find(price => {
          let filtered =  _.omit(price, ['price'])
          return _.isEqual(_.values(filtered), _.values(this.attributesValue))
        })
      }
    },
    data() {
      return {
        attributesValue: {},
        prices: []
      }
    },
    created() {
      this.getAttributes.forEach(attribute => {
        if(attribute.attribute_list_value.length > 0) {
          let obj = {};
          obj[attribute.id] = attribute.attribute_list_value[0].id
          this.attributesValue = Object.assign({}, this.attributesValue, obj)
        }
      })

      this.prices = this.product.prices.map(price => {
        return _.omit(price, ['price'])
      })
    },
    methods: {
    }
  }
</script>