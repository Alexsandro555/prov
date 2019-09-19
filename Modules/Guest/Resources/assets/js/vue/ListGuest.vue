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
                <td class="text-xs-left">{{ props.item.id }}</td>
                <td class="text-xs-left">{{ props.item.user_agent }}</td>
                <td class="text-xs-left">
                  <span v-if="props.item.utm_source">Источник перехода: {{props.item.utm_source}} / </span>
                  <span v-if="props.item.utm_medium">Источник перехода: {{props.item.utm_medium}} / </span>
                  <span v-if="props.item.utm_campaign">Источник перехода: {{props.item.utm_campaign}} / </span>
                  <span v-if="props.item.utm_term">Источник перехода: {{props.item.utm_term}}</span>
                </td>
                <td class="text-xs-left">
                  <pre>
                    {{props.item.props}}
                  </pre>
                </td>
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
          {
            text: 'utm-метки',
            align: 'center',
            value: 'id',
            sortable: false
          },
          {
            text: 'Параметры запроса',
            align: 'center',
            value: 'params',
            sortable: false
          }
        ],
        search: ''
      }
    },
    computed: {
      ...mapState('guests', ['items', 'loading'])
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.initialization().then(response => {
          vm.loadRelations().then(response => {
            vm.load().then(response => {
              vm.$store.commit('SET_VARIABLE',{module: 'guests', variable: 'loading', value: false}, {root: true})
            })
          })
        })
      })
    },
    methods: {
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
      })
    }
  }
</script>