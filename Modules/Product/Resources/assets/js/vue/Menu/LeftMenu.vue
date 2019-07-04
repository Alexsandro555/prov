<template>
  <div class="left-menu">
    <img class="menu-left-img hidden-sm-and-down" src="/images/menu-left-hr.png"/>
    <v-card class="menu-left-wrappers hidden-sm-and-down">
      <v-list class="list-menu-left">
        <v-list-tile class="menu-left__header">
          <v-list-tile-content>
            <v-list-tile-title @click="clickToggle" class="text-md-center">{{selectedCatalog}}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <template v-if="toggle" v-for="productCategory in section === 0?items:getMenus">
          <v-menu offset-x open-on-hover class="menu-left-h">
            <v-list-group :value="false" class="menu-left__group" slot="activator">
              <v-list-tile slot="activator">
                <v-list-tile-content>
                  <v-list-tile-title>
                    {{ productCategory.title }}
                  </v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
              <v-list-tile v-for="typeProduct in productCategory.type_products" :key="typeProduct.id">
                <v-list-tile-content>
                  <v-list-tile-title @click="goToPage('/'+getSection+'/'+productCategory.url_key+'/'+typeProduct.url_key)" class="menu-left-item-el" slot="activator">
                    <img src="/images/menu-left-item-sub-arr.png"/>
                    {{ limit(typeProduct.title, 27)}}
                  </v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
            </v-list-group>
            <div v-if="productCategory.type_products.length > 0 && checkLineProducts(productCategory.type_products)" class="sub-menu" style="width: 600px">
              <div style="display: inline-block" row wrap v-for="typeProduct in productCategory.type_products" :key="typeProduct.id">
                <v-layout column wrap v-if="typeProduct.line_products.length > 0">
                  <span class="sub-menu__header">{{typeProduct.title}}</span>
                  <v-list>
                    <v-list-tile class="sub-menu__list-tile" v-for="lineProduct in typeProduct.line_products" :key="lineProduct.id">
                      <a :href="'/catalog/'+productCategory.url_key+'/'+typeProduct.url_key+'/'+lineProduct.url_key">{{lineProduct.title}}</a>
                    </v-list-tile>
                  </v-list>
                </v-layout>
              </div>
            </div>
          </v-menu>
        </template>
        <v-list-tile class="menu-left__footer">
          <v-list-tile-content>
            <v-list-tile-title @click="clickToggle" class="text-md-center collapse">{{toggle?'Свернуть':'Развернуть'}}
            </v-list-tile-title>
          </v-list-tile-content>
          <div class="menu-left__social-icons">
            <p class="menu-left__social-icons-header text-md-left">Мы в <span
              class="content__subheader hidden-sm-and-down">соцсетях</span></p><br>
            <img src="/images/footer-social-icons-f.png"/>
            <img src="/images/footer-social-icons-t.png"/>
            <img src="/images/footer-social-icons-in.png"/>
            <img src="/images/footer-social-icons-ok.png"/>
            <img src="/images/footer-social-icons-y.png"/>
            <img src="/images/footer-social-icons-i.png"/>
          </div>
        </v-list-tile>
      </v-list>
    </v-card>
  </div>
</template>
<script>
  import {mapActions, mapState, mapMutations, mapGetters} from 'vuex'
  import { GETTERS } from '@product/constants'
  import { ACTIONS, GLOBAL } from '@/constants'

  export default {
    name: 'LeftMenu',
    props: {
      propToggle: {
        type: Boolean,
        default: true
      }
    },
    data() {
      return {
        toggle: this.propToggle
      }
    },
    computed: {
      ...mapState('left_menu', ['items']),
      ...mapState('sections', ['section']),
      ...mapGetters('sections', ['allowedLineProductsIds']),
      getMenus() {
       return this.handleElements(this.items, this.allowedLineProductsIds)
      },
      getSection() {
        switch (this.section) {
          case 1:
            return 'catalog/section-birds'
          case 2:
            return 'catalog/section-cows'
          case 3:
            return 'catalog/section-pigs'
          case 4:
            return 'catalog/section-other'
          default:
            return 'catalog'
        }
      },
      selectedCatalog() {
        switch (this.section) {
          case 1:
            return 'Птицеводство'
          case 2:
            return 'Скотоводство'
          case 3:
            return 'Свиноводство'
          case 4:
            return 'Прочее'
          default:
            return 'Каталог продукции'
        }
      }
    },
    mounted() {
      this.loadAll()
    },
    methods: {
      ...mapActions('left_menu', { loadAll: GLOBAL.LOAD_ALL }),
      clickToggle() {
        this.toggle = !this.toggle
      },
      goToPage(url) {
        window.location.href = url
      },
      limit(text, length) {
        return text.length > length?text.substr(0, length)+"...":text
      },
      checkLineProducts(typeProducts) {
        let enable = false
        typeProducts.forEach(typeProduct => {
          if(typeProduct.line_products.length > 0) enable = true
        })
        return enable
      },
      handleElements(items, ids) {
        return this.items.map(item => {
          let typeProducts = item.type_products.map(item => {
            let lineProducts = item.line_products.filter(item => ids.includes(item.id))
            return Object.assign({}, item, {line_products: lineProducts})
          }).filter(item => item.line_products.length > 0)
          return Object.assign({}, item, {type_products: typeProducts})
        }).filter(item => item.type_products.length > 0)
      }
    }
  }
</script>
<style>
  .transition {
    -webkit-transition: all 0.5s ease-in-out;
    -moz-transition: all 0.5s ease-in-out;
    -o-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out;
  }
</style>