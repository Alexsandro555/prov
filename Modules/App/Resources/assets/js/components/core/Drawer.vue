<template>
  <v-navigation-drawer
    class="material"
    id="app-drawer"
    v-model="inputValue"
    app
    dark
    floating
    persistent
    mobile-break-point="991"
    width="260"
  >
    <v-img
      :src="image"
      height="100%"
    >
      <v-col
        tag="v-list"
        class="fill-height navigation-list"
        three-line
      >
        <v-list-item class="account">
          <v-list-item-avatar :color="color">
            <v-img src="images/logo-small.png" height="34" contain/>
          </v-list-item-avatar>
          <v-list-item-title class="account-name">Лидер</v-list-item-title>
        </v-list-item>
        <v-divider/>
        <v-list-item
          v-for="(link, i) in links"
          :key="i"
          :to="link.to"
          :class="check(link)"
          nav
          dense
        >
          <v-list-item-action>
            <v-icon>{{ link.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-subtitle
            v-text="link.text"
          />
        </v-list-item>
      </v-col>
    </v-img>
  </v-navigation-drawer>
</template>

<script>
// Utilities
import {
  mapMutations,
  mapState
} from 'vuex'

import routes from '@product/routes'
import articleRoutes from '@article/routes'
import newsRoutes from '@news/routes'
import pagesRoutes from '@pages/routes'
import razRoutes from '@section/routes'
import callbackRoutes from '@callback/routes'

export default {
  props: {
    opened: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    logo: 'favicon.ico',
    links: []
  }),
  mounted() {
    this.handleRoutes(routes)
    this.handleRoutes(articleRoutes)
    this.handleRoutes(newsRoutes)
    this.handleRoutes(pagesRoutes)
    this.handleRoutes(razRoutes)
    this.handleRoutes(callbackRoutes)
    //this.links.push({divider: true})
    //this.links.push({heading: 'Управление статьями'})

  },
  computed: {
    ...mapState('app', ['image', 'color']),
    inputValue: {
      get () {
        return this.$store.state.app.drawer
      },
      set (val) {
        this.setDrawer(val)
      }
    },
    items () {
      return this.$t('Layout.View.items')
    }
  },

  methods: {
    ...mapMutations('app', ['setDrawer', 'toggleDrawer']),
    handleRoutes(routes) {
      routes.forEach(route => {
        let link = [];
        link['to'] = route.path;
        link['icon'] = '';
        link['text'] = route.name;
        this.links.push(link);
      })
    },
    check(path) {
      let arrPath = _.split(this.$route.fullPath,'/',2)
      return arrPath[1] === path.to.replace("/","") ? 'warning': ''
    }
  }
}
</script>

<style lang="scss">
  #app-drawer {
    .navigation-list {
      overflow-y: scroll;
    }
    .v-list__tile {
      border-radius: 4px;

      &--buy {
        margin-top: auto;
        margin-bottom: 17px;
      }
    }
    .account {
      min-height: 80px;
    }
    .account-name {
      font-weight: bold;
    }
  }
</style>
