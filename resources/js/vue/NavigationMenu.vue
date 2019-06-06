<template>
  <div>
    <v-btn dark class="hidden-md-and-up" @click="open">
      <v-icon>reorder</v-icon>
    </v-btn>
    <v-navigation-drawer v-model="drawer" temporary absolute dark
                         style="position:fixed; top:0; left:0; overflow-y:scroll;">
      <v-toolbar flat>
        <v-list class="pa-0">
          <v-list-tile>
            Страницы
          </v-list-tile>
        </v-list>
      </v-toolbar>
      <v-list>
        <v-list-tile @click="goToPage(`/about`)">О компании</v-list-tile>
        <v-list-tile @click="goToPage(`/news/list`)">Новости</v-list-tile>
        <v-list-tile @click="goToPage(`/sale`)">Акции</v-list-tile>
        <v-list-tile @click="goToPage(`/delivery`)">Доставка и оплата</v-list-tile>
        <v-list-tile @click="goToPage(`/article/list`)">Статьи</v-list-tile>
        <v-list-tile @click="goToPage(`/contacts`)">Контакты</v-list-tile>
        <!--<v-subheader>Рубрикатор</v-subheader>-->
      </v-list>
      <v-divider></v-divider>
      <template v-for="itemMenu in menu">
        <v-toolbar :key="itemMenu.id" flat>
          <v-list class="pa-0">
            <v-list-tile @click="goToPage(`/catalog/${itemMenu.url_key}`)">
              {{itemMenu.title}}
            </v-list-tile>
          </v-list>
        </v-toolbar>
        <v-list v-for="subItem in itemMenu.type_products" :key="'sub'+subItem.id">
          <v-list-tile @click="goToPage(`/catalog/${itemMenu.url_key}/${subItem.url_key}`)">
            {{subItem.title}}
          </v-list-tile>
        </v-list>
      </template>
    </v-navigation-drawer>
  </div>
</template>
<script>
  export default {
    props: {},
    data: function () {
      return {
        drawer: false,
        menu: []
      }
    },
    mounted() {
      this.getMenu()
    },
    methods: {
      open() {
        this.drawer = !this.drawer
      },
      goToPage(url) {
        window.location.href = url
      },
      getMenu() {
        axios.get('/menu-left').then(response => response.data).then(response => {
          this.menu = response
        }).catch(error => {
        })
      }
    }
  }
</script>