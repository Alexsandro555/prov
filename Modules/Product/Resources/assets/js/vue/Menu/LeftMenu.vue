<template>
  <div id="left-menu">
    <img class="menu-left-img" src="/images/menu-left-hr.png"/>
    <v-card class="left-menu__content">
      <v-list class="list-menu-left">
        <v-list-item class="left-menu__header">
          <v-list-item-content>
            <v-list-item-title @click="clickToggle" class="text-center">{{selectedCatalog}}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <template v-if="toggle" v-for="productCategory in productCategories">
          <v-menu offset-x open-on-hover class="menu-left-h">
            <template v-slot:activator="{ on }">
              <v-list-group :value="false" class="menu-left__group" v-on="on">
                <template v-slot:activator>
                  <v-list-item-content>
                      {{ productCategory.title }}
                  </v-list-item-content>
                </template>
                <v-list>
                  <v-list-item v-for="typeProduct in productCategory.type_products" :key="typeProduct.id" class="menu-left__group-item" >
                    <v-list-item-content>
                      <v-list-item-title @click="goToPage('/catalog/'+productCategory.url_key+'/'+typeProduct.url_key)" slot="activator">
                        <img src="/images/menu-left-item-sub-arr.png"/>
                        {{ limit(typeProduct.title, 27)}}
                      </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
              </v-list-group>
            </template>
            <div id="sub-menu" style="width: 600px;">
              <div v-for="items in chunkedData(productCategory.type_products,2)">
                <v-row>
                  <v-col cols="6" v-if="items[0]">
                    <span class="sub-menu__header">{{items[0].title}}</span><br>
                    <v-list class="sub-menu__list">
                      <v-list-item  v-for="lineProduct in items[0].line_products" :key="lineProduct.id">
                        <a :href="'/catalog/'+productCategory.url_key+'/'+items[0].url_key+'/'+lineProduct.url_key">{{lineProduct.title}}</a>
                      </v-list-item>
                    </v-list>
                  </v-col>
                  <v-col cols="6" v-if="items[1]">
                    <span class="sub-menu__header">{{items[1].title}}</span><br>
                  </v-col>
                </v-row>
              </div>
            </div>
          </v-menu>
        </template>
        <v-list-item class="menu-left__footer">
          <v-list-item-content>
            <v-list-item-title @click="clickToggle" class="text-md-center collapse">{{toggle?'Свернуть':'Развернуть'}}</v-list-item-title>
          </v-list-item-content>
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
        </v-list-item>
      </v-list>
    </v-card>
  </div>
</template>
<script>
  import {mapActions, mapState, mapMutations, mapGetters} from 'vuex'
  import { GETTERS } from '@product/constants'
  import { ACTIONS, GLOBAL } from '@/constants'
  import axios from 'axios'

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
        toggle: this.propToggle,
        productCategories: []
      }
    },
    computed: {
      ...mapState('left_menu', ['items']),
      ...mapState('sections', ['current', 'items']),
      ...mapGetters('sections', ['allowedLineProductsIds']),
      selectedCatalog() {
        let section = this.items.find(item => item.id == this.current)
        return section?section.title:'Кталог продкции'
      }
    },
    mounted() {
      axios.get('/left-menu')
        .then(response => response.data)
        .then(response => {
          this.productCategories = response
        })
    },
    methods: {
      ...mapActions('left_menu', { loadAll: GLOBAL.LOAD_ALL }),
      clickToggle() {
        this.toggle = !this.toggle
      },
      chunkedData(data) {
        return _.chunk(data, 2)
      },
      goToPage(url) {
        window.location.href = url
      },
      limit(text, length) {
        return text.length > length?text.substr(0, length)+"...":text
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