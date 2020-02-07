<template>
  <div>
    <router-view></router-view>
  </div>
</template>
<script>
  import {mapActions, mapState} from 'vuex'
  import {ACTIONS} from '@auth/constants'

  export default {
    name: 'Application',
    data() {
      return {
        dark: localStorage.getItem('dark') == "true"?true:false,
        drawer: null,
        items: [
          {divider: true},
          {heading: 'Управление продуктами'},
          {
            text: 'Категории продуктов',
            path: '/categories'
          },
          /*{
            text: 'ТНВЭД',
            path: '/tnved'
          },*/
          {
            text: 'Типы продуктов',
            path: '/types'
          },
          {
            text: 'Линейки продукции',
            path: '/lines'
          },
          {
            text: 'Производители',
            path: '/producers'
          },
          {
            text: 'Еденицы измерения атрибутов',
            path: '/attributes-units'
          },
          {
            text: 'Группы атрибутов',
            path: '/attributes-groups'
          },
          {
            text: 'Атрибуты',
            path: '/attributes'
          },
          {
            text: 'Привязка атрибутов',
            path: '/binding'
          },
          {
            text: 'Продукция',
            path: '/'
          },
          {divider: true},
          {heading: 'Работа с сайтом'},
          {
            text: 'Статьи',
            path: '/articles'
          },
          {
            text: 'Новости',
            path: '/news'
          },
          {
            text: 'Страницы',
            path: '/pages'
          },
          {
            text: 'Обратные звонки',
            path: '/callbacks'
          },
          {
            text: 'Заказы',
            path: '/orders'
          },
          {
            text: 'Загрузка атрибутов',
            path: '/attributes/loading'
          },
          {
            text: 'Ипорт продукции',
            path: '/import'
          },
          {
            text: 'Изображения',
            path: '/images'
          },
          {
            text: 'Посетители',
            path: '/guests'
          }
        ]
      }
    },
    computed: {
      ...mapState('initializer', ['darkColor']),
    },
    methods: {
      ...mapActions('Auth', {logout: ACTIONS.AUTH_LOGOUT}),
      goToSite() {
        window.location.href = '/'
      },
      exit() {
        this.logout().then(() => {
          window.location.href = '/'
        })
      },
      chengeColor() {
        this.dark = !this.dark
        localStorage.setItem('dark', this.dark)
      }
    }
  }
</script>