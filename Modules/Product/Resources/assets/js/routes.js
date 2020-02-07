
import Products from '@product/vue/Product'
import Product from '@product/vue/Product/Item'
import Attributes from '@product/vue/Product/Attributes'

import ProductCategory from '@product/vue/ProductCategory'
import TypeProduct from '@product/vue/TypeProduct'
import LineProduct from '@product/vue/LineProduct'
import Producer from '@product/vue/Producer'
import AttributeUnit from '@product/vue/AttributeUnit'
import AttributeGroup from '@product/vue/AttributeGroup'
import Attribute from '@product/vue/Attribute'
import AttributeBinding from '@product/vue/Attribute/Binding'

const routes = [
  {
    path: '/product-categories',
    name: 'Категории продукции',
    component: ProductCategory
  },
  {
    path: '/type-products',
    name: 'Типы продукции',
    component: TypeProduct
  },
  {
    path: '/line-products',
    name: 'Линейки продукции',
    component: LineProduct
  },
  {
    path: '/producers',
    name: 'Производители',
    component: Producer
  },
  {
    path: '/attribute-units',
    name: 'Еденицы измерения',
    component: AttributeUnit,
  },
  {
    path: '/attribute-groups',
    name: 'Группы атрибутов',
    component: AttributeGroup,
  },
  {
    path: '/attributes',
    name: 'Атрибуты',
    component: Attribute,
  },
  {
    path: '/attribute-binding',
    name: 'Привязка атрибутов',
    component: AttributeBinding
  },
  {
    path: '/products',
    name: 'Продукция',
    component: Products,
    children: [
      {
        path: ':product_id',
        name: 'Продукт',
        component: Product,
        props: (route) => ({product_id: Number.parseInt(route.params.product_id, 10)}),
        children: [
          {
            path: 'attributes',
            name: 'Атрибуты продукции',
            component: Attributes
          }
        ]
      }
    ]
  }
];

export default routes