<template>
  <div class="left-menu">
    <img class="menu-left-img hidden-sm-and-down" src="/images/menu-left-hr.png"/>
    <v-card class="menu-left-wrappers hidden-sm-and-down">
      <v-list class="list-menu-left">
        <v-list-tile class="menu-left__header">
          <v-list-tile-content>
            <v-list-tile-title @click="clickToggle" class="text-md-center">Каталог продукции</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <template v-if="toggle" v-for="productCategory in menu">
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
                  <v-list-tile-title @click="goToPage('/catalog/'+typeProduct.url_key)" class="menu-left-item-el"
                                     slot="activator">
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
                      <a :href="'/catalog/'+typeProduct.url_key+'/'+lineProduct.url_key">{{lineProduct.title}}</a>
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
  export default {
    name: 'LeftMenu',
    props: {
      propToggle: {
        type: Boolean,
        default: true
      }
    },
    data: function () {
      return {
        menu: [],
        toggle: false
      }
    },
    mounted: function () {
      this.getMenu()
      this.toggle = this.propToggle
    },
    methods: {
      getMenu() {
        axios.get('/menu-left')
          .then(response => response.data)
          .then(response => {
            this.menu = response
          })
      },
      goToPage(url) {
        window.location.href = url
      },
      clickToggle() {
        this.toggle = !this.toggle
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
      }
    }
  }
</script>
<style>
  .left-menu {
    position: absolute;
    border-radius: 0 0 10px 10px;
  }

  .collapse {
    font-size: 0.8em;
    text-transform: uppercase;
  }
</style>