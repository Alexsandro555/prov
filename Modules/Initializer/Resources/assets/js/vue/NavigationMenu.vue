<template>
  <v-navigation-drawer v-model="$root.drawer" temporary absolute style="position:fixed; top:0; left:0; overflow-y:scroll;">
    <v-list class="navigation-menu__list">
      <v-list-item>
        <v-row class="justify-center align-center">
          <v-col cols="4">
            <v-btn @click.prevent="close" class="navigation-btn" fab icon><v-icon>close</v-icon> МЕНЮ</v-btn>
          </v-col>
          <v-col>
            <a class="navigation-telephone" href="tel: 8(495)123 33 21">+7(495)123 33 21</a>
          </v-col>
        </v-row>
      </v-list-item>
      <v-list-item><a href="/about">О компании</a></v-list-item>
      <v-divider></v-divider>
      <v-list-item><a href="/article/list">Статьи</a></v-list-item>
      <v-divider></v-divider>
      <v-list-item><a href="/equipment">Акции</a></v-list-item>
      <v-divider></v-divider>
      <v-list-item><a href="/delivery">Доставка и оплата</a></v-list-item>
      <v-divider></v-divider>
      <v-list-item><a href="/contacts">Контакты</a></v-list-item>
    </v-list>
    <!--<v-navigation-drawer v-model="subMenu" temporary absolute style="position:fixed; top: 50px; left: 0; overflow: hidden; overflow-y: auto;">
      <v-list>
        <v-list-tile @click="back">Назад</v-list-tile>
        <v-divider></v-divider>
        <v-list-tile><a href="/article/list">Статьи</a></v-list-tile>
        <v-divider></v-divider>
        <v-list-tile>2</v-list-tile>
      </v-list>
    </v-navigation-drawer>-->
  </v-navigation-drawer>
</template>
<script>
  export default {
    props: {},
    data: function () {
      return {
        drawer: false,
        //subMenu: false
      }
    },
    methods: {
      goToPage(url) {
        window.location.href = url
      },
      close() {
        this.$root.drawer = false
      },
      /*open() {
        this.subMenu = true
      },
      back() {
        this.subMenu = false
      }*/
    }
  }
</script>

<style scoped>
  .navigation-menu__list a {
    color: #000;
    text-decoration: none;
  }
  .navigation-menu__list a:hover {
    color: #0F2E5D;
  }
  .navigation-telephone {
    text-decoration: none;
    color: #000;
    font-weight: bold;
  }
</style>