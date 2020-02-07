<template>
  <v-flex xs12>
    <table v-if="paginatedProducts.length>0" cellspacing="0" cellpadding="0" border="0" class="filter-table" >
      <thead class="filter-table__thead">
      <th class="filter-table__th">Наименование</th>
      <th>Цена</th>
      <th class="hidden-md-and-down" v-for="attribute in headerAttributes">{{ attribute.title }}{{attribute.attribute_unit?', '+attribute.attribute_unit.title:''}}
      </th>
      <th></th>
      </thead>
      <tbody>
      <tr v-for="product in paginatedProducts" :key="product.id">
        <td class="filter-table__td"><a class="filter-table__title" :href="'/catalog/detail/'+product.url_key">{{ product.product_category.title_element }}<br> {{product.title}}</a>
        </td>
        <td>{{product.price}}</td>
        <td text-xs-center class="hidden-md-and-down" v-for="attribute in headerAttributes">
          {{getAttributeValue(attribute, product)}}
        </td>
        <td align="center">
          <v-btn v-if="product.need_order" onclick="ym(56003506,'reachGoal','requestPrice74951233321'); gtag('event', 'click', {'event_category': 'requestPrice','event_label': 'request price','value': 5}); return true;" @click="$root.discoverDiscount(`Добрый день! \nПрошу сообщить стоимость и наличие ${product.title}. \nСпасибо!`)" icon small><v-icon color="primary">contact_support</v-icon></v-btn>
          <v-btn icon v-else onclick="ym(56003506,'reachGoal','cartClick74951233321'); gtag('event', 'click', {'event_category': 'cart','event_label': 'cart click main page','value': 1}); return true;" @click="addCart(product.id)" small><v-icon color="primary">add_shopping_cart</v-icon></v-btn>
        </td>
      </tr>
      </tbody>
    </table>
    <br>
    <v-flex xs12  text-xs-center>
      <v-pagination v-if="colPages > 1" :total-visible="7" v-model="page" :page="page"
                    :length="colPages"></v-pagination>
    </v-flex>
  </v-flex>
</template>


<script>
  import vuex from 'vuex'
  import { mapActions, mapMutations } from 'vuex'
  import {ACTIONS, MUTATIONS} from '@cart/constants'

  export default {
    props: {
      products: {
        type: Array,
        default: () => []
      },
      attributes: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
        page: 1,
        perPage: 30,
      }
    },
    computed: {
      colPages() {
        return Math.floor(this.products.length / this.perPage) + 1
      },
      headerAttributes() {
        return this.attributes.filter(attribute => attribute.list_viewed)
      },
      paginatedProducts() {
        return _.slice(this.products, (this.page - 1) * this.perPage, (this.page - 1) * this.perPage + this.perPage)
      }
    },
    watch: {
      products(values) {
        this.page = 1
      }
    },
    methods: {
      // todo: - оптимизировать
      getAttributeValue(attribute, product) {
        if (product.attributes.length == 0) return ''
        let result = product.attributes.find(item => item.id == attribute.id)
        if (!result) return ''
        if (attribute.attribute_list_value.length > 0) {
          let value = attribute.attribute_list_value.find(item => item.id == result.pivot.list_value)
          return value?value.title:''
        } else {
          return ''
        }
      },
      addCart(id) {
        const count = 1
        this.addCartItem({id, count})
        this.showCartModal()
      },
      ...mapActions('cart',{addCartItem: ACTIONS.ADD_CART}),
      ...mapMutations('cart', {showCartModal: MUTATIONS.SHOW_MODAL})
    }
  }
</script>

<style scoped>

  .filter-table {
    font-size: 16px;
    background: white;
    width: 100%;
    //max-width: 70%;
    //width: 70%;
    //width: 875px;
    border-collapse: collapse;
    text-align: left;
  }

  .filter-table th {
    font-weight: normal;
    color: #039;
    padding: 10px 15px;
    background: #e8edff;
  }

  .filter-table td {
    color: #669;
    border-top: 1px solid #e8edff;
    padding: 10px 15px;
  }

  .filter-table tr:hover {
    background: #e8edff;
  }

  .filter-table tr:nth-child(2n) {
    background: #e8edff;
  }

  .filter-table__title {
    text-decoration: none;
  }

  .filter-table__title:hover {
    color: #29435c;
  }

</style>