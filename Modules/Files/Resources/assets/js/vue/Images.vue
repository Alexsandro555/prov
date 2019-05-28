<template>
  <v-container>
    <v-layout wrap row>
      <v-flex xs12 class="text-xs-center">
        <v-card>
          <v-card-title>
            <h1>Изображения</h1>
            <v-spacer></v-spacer>
            <v-text-field v-model="search" append-icon="search" label="Поиск" single-line hide-details></v-text-field>
          </v-card-title>
          <v-card-text>
            <v-data-table :headers="headers"
                          :items="items"
                          :search="search"
                          :loading="loading"
                          :rows-per-page-items="[10, 20, 50, { 'text': '$vuetify.dataIterator.rowsPerPageAll', 'value': -1 } ]"
                          rows-per-page-text="Строк на странице:"
                          class="elevation-1">
              <template slot="items" slot-scope="props">
                <td class="text-xs-left">{{ props.item.id }}</td>
                <td class="text-xs-left">
                  <img :src="'/storage/'+props.item.config.files.small.filename "/>
                </td>
                <td class="justify-center layout px-0">
                  <!--<v-btn @click="goToPage(props.item)" icon class="mx-0">
                      <v-icon>find_in_page</v-icon>
                  </v-btn>-->
                  <v-btn icon class="mx-0" @click="$router.push({name: 'edit-images', params: {id: props.item.id.toString()}})">
                    <v-icon color="teal">edit</v-icon>
                  </v-btn>
                  <!--<v-btn :disabled="props.item.url_key === 'po-umolchaniyu'" icon class="mx-0" @click="deleteItem(props.item)">
                      <v-icon color="pink">delete</v-icon>
                  </v-btn>-->
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
            text: 'Изображение',
            value: 'config.files.small.filename',
            sortable: true
          },
          {
            text: 'Действия',
            align: 'center',
            value: 'title',
            sortable: false
          }
        ],
        search: '',
        images: []
      }
    },
    computed: {
      ...mapState('files', ['items', 'loading']),
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        Promise.all([vm.loadAll(), vm.loadAllAttributes()]).then(response => {
          vm.$store.commit('SET_VARIABLE',{module: 'files', variable: 'loading', value: false}, {root: true})
        })
      })
    },
    methods: {
      ...mapActions('files', { load: GLOBAL.LOAD, loadAll: GLOBAL.LOAD_ALL }),
      ...mapActions('attributes', {loadAllAttributes: GLOBAL.LOAD_ALL })
    }
  }
</script>