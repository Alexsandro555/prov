<template>
  <v-container>
    <v-layout wrap row>
      <v-flex xs12 class="text-xs-center">
        <v-card>
          <v-card-title>
            <h1>Посетители</h1>
            <v-spacer></v-spacer>
            <v-text-field v-model="search" append-icon="search" label="Поиск" single-line hide-details></v-text-field>
          </v-card-title>
          <v-card-text>
            <v-data-table :headers="headers"
                          :items="items"
                          :search="search"
                          :loading="loading"
                          :rows-per-page-items="[50, { 'text': '$vuetify.dataIterator.rowsPerPageAll', 'value': -1 } ]"
                          rows-per-page-text="Строк на странице:"
                          class="elevation-1">
              <template slot="items" slot-scope="props">
                <tr @click="props.expanded = !props.expanded">
                  <td class="text-xs-left">{{ props.item.id }}</td>
                  <td class="text-xs-left">{{ props.item.user_agent }}</td>
                </tr>
              </template>
              <template slot="expand" slot-scope="props">
                <v-card flat>
                  <v-card-title>
                    <h3>Переходы</h3>
                  </v-card-title>
                  <v-card-text>
                    <v-data-table :headers="subHeaders"
                                  :items="getPages(props.item.id)"
                                  :search="subSearch"
                                  :rows-per-page-items="[50, { 'text': '$vuetify.dataIterator.rowsPerPageAll', 'value': -1 } ]"
                                  rows-per-page-text="Строк на странице:"
                                  class="elevation-1">
                      <template slot="items" slot-scope="props">
                        <td class="text-xs-left">{{ props.item.id }}</td>
                        <td class="text-xs-left">{{ props.item.url }}</td>
                        <td class="text-xs-left">{{ props.item.ip }}</td>
                        <td class="text-xs-left">{{ props.item['utm_source'] }}</td>
                        <td class="text-xs-left">{{ props.item['utm_medium'] }}</td>
                        <td class="text-xs-left">{{ props.item['utm_campaign'] }}</td>
                        <td class="text-xs-left">{{ props.item['utm_content'] }}</td>
                        <td class="text-xs-left">{{ props.item['utm_term'] }}</td>
                        <td class="text-xs-left"><pre>{{ props.item.params }}</pre></td>
                      </template>
                    </v-data-table>
                  </v-card-text>
                </v-card>
              </template>
              <template v-if="loading" slot="no-data">
                <br>
                <v-progress-circular indeterminate :size="100" color="primary"></v-progress-circular>
                <br>
                <br>
              </template>
              <template v-if="!loading" slot="no-data">
                <v-alert v-if="!loading" :value="true" color="error" icon="warning">
                  Извините, нет данных для отображения :(
                </v-alert>
              </template>
              <v-alert slot="no-results" :value="true" color="error" icon="warning">
                По ключевой фразе "{{ search }}" ничего не найдено.
              </v-alert>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
  import {ACTIONS, GLOBAL} from "@/constants";
  import {mapActions, mapState, mapGetters} from 'vuex'
  import mycomponent from './ListGuestPages'

  export default {
    props: {},
    data: function () {
      return {
        headers: [
          {
            text: '#',
            align: 'left',
            sortable: true,
            value: 'id'
          },
          {
            text: 'User-Agent',
            value: 'user_agent',
            sortable: true
          },
          /*{
            text: 'Действия',
            value: 'user_agent',
            sortable: false
          }*/
        ],
        subHeaders: [
          {
            text: '#',
            align: 'left',
            sortable: true,
            value: 'id'
          },
          {
            text: 'url',
            align: 'left',
            sortable: false,
            value: 'url'
          },
          {
            text: 'ip',
            align: 'left',
            sortable: false,
            value: 'ip'
          },
          {
            text: 'Источник перехода',
            value: 'utm_source',
            sortable: true
          },
          {
            text: 'Тип трафика',
            value: 'utm_medium',
            sortable: true
          },
          {
            text: 'Название рекламной кампании',
            value: 'utm_campaign',
            sortable: true
          },
          {
            text: 'Дополнительная информация',
            value: 'utm_content',
            sortable: false
          },
          {
            text: 'Ключевая фраза',
            value: 'utm_term',
            sortable: false
          },
          {
            text: 'Все параметры',
            value: 'params',
            sortable: false
          }
        ],
        subSearch: '',
        search: '',
        dialog: false,
        pages: []
      }
    },
    computed: {
      ...mapState('guests', ['items', 'loading']),
      ...mapState('guest_pages', {'viewedPages': 'items'})
    },
    component: {
      mycomponent
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.initialization().then(response => {
          vm.loadRelations().then(response => {
            vm.load().then(response => {
              vm.$store.commit('SET_VARIABLE',{module: 'guests', variable: 'loading', value: false}, {root: true})
              vm.loadPages()
            })
          })
        })
      })
    },
    methods: {
      getPages(id) {
        return this.viewedPages.filter(item => item.guest_id == id)
      },
      /*goToPage(item) {
        let url = '/$NAME_LOWER$/detail/'
        url = url + item.url_key
        window.open(url, '_blank')
      },*/
      ...mapActions('guests', {
        load: GLOBAL.LOAD,
        add: GLOBAL.ADD,
        delete: GLOBAL.DELETE,
        initialization: GLOBAL.INITIALIZATION,
        loadAll: GLOBAL.LOAD_ALL,
        loadRelations: GLOBAL.LOAD_RELATIONS
      }),
      ...mapActions('guest_pages', {loadPages: GLOBAL.LOAD}),
    }
  }
</script>