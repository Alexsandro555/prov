<template>
  <div class="menu-left hidden-sm-and-down">
    <div class="menu-left--shadow">
      <div class="menu-left__header">
        Каталог продукции
        <img v-if="!toggle" @click="clickToggle" src="/images/menu-left-arrow.png"/>
        <img v-else @click="clickToggle" src="/images/menu-left-arrow-up.png"/>
      </div>
      <div v-show="toggle">
        <div class="menu-left__items">
          <v-list class="menu-left__list">
            <v-menu offset-x open-on-hover v-for="menuItem in menu" :key="menuItem.id">
                <v-list-tile @click="goToPage(`/catalog/${menuItem.url_key}`)" slot="activator">
                    <div class="menu-left__list--text">
                        {{ menuItem.title }}
                    </div>
                </v-list-tile>
                <v-list class="menu-left__list tom" onmouseover="this.style.backgroundColor='#29435c';" v-if="menuItem.type_products && menuItem.type_products.length>0">
                    <v-list-tile @click="goToPage(`/catalog/${menuItem.url_key}/${subMenu.url_key}`)"
                                 :class="key%2?'menu-left__sub--dark'
                                 :'menu-left__sub--light'"
                                 v-for="(subMenu, key) in menuItem.type_products"
                                 :key="subMenu.id">
                        <div class="menu-left__sub__list--text">
                            {{subMenu.title}}
                        </div>
                    </v-list-tile>
                </v-list>
            </v-menu>
          </v-list>
        </div>
      </div>
      <div class="price-wrapper">
        <div class="price">
          <v-layout row wrap text-xs-center>
            <v-flex xs5 class="price__img">
              <img src="/images/img-price.png"/>
            </v-flex>
            <v-flex xs6 class="price__download">
              Скачать<br>
              <span class="price__download--next">прайс</span>
            </v-flex>
          </v-layout>
        </div>
      </div>
    </div>
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
        axios.get('/menu-left').then(response => response.data).then(response => {
          this.menu = response
        })
      },
      goToPage(url) {
        window.location.href = url
      },
      clickToggle() {
        this.toggle = !this.toggle
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