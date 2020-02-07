<template>
  <v-navigation-drawer v-model="$root.drawer2"  width="100%" style="margin-top: 123px;"right :temporary="false" hide-overlay class="navigation-menu-category">
    <v-list>
      <v-list-item class="style-tile" v-for="productCategory in menu" :key="productCategory.id"  @click="goToPage('/catalog/'+productCategory.url_key)">
        <v-list-item-content class="navigation-menu-category__item">
          {{productCategory.title}}
        </v-list-item-content>
        <v-list-item-action>
          <v-btn icon>
            <v-icon color="#000">keyboard_arrow_right</v-icon>
          </v-btn>
        </v-list-item-action>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>
<script>
  import axios from "axios"

  export default {
    props: {},
    data: function () {
      return {
        drawer: false,
        menu: []
      }
    },
    mounted() {
      this.load()
    },
    methods: {
      goToPage(url) {
        window.location.href = url
      },
      load() {
        axios.get('/menu-left')
          .then(response => response.data)
          .then(response => {
            this.menu = response
          })
      }
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


  .navigation-menu-category {
    position: absolute;
    top: 104px;
    left: 0;
    z-index: 100;
    background-color: #fff;
    box-shadow: 0 0 40px rgba(51, 58, 65, 0.1);
    overflow-y: auto;

    .navigation-menu-category__item:hover {
      background-color: #0F2E5D;
    }
  }
  .style-tile:hover {
    background-color: green ligthen-1;
  }
</style>