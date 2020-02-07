<template>
  <v-container fill-height>
    <v-row>
      <v-col xs12>
        <v-dialog persistent @keydown.esc="onCancel" v-model="dialog" max-width="60%">
          <v-card>
            <v-card-title>
              <v-flex px-4 class="headline"><h3>Редактирование</h3></v-flex>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex v-if="dialog" xs12>
                    <slot :formFields="formFields"
                          :editedItem="editedItem"
                          :getRules="getRules"
                          :update="updateField"
                          name="form-area">
                      <v-form>
                        <template v-for="(field, num) in formFields">
                          <form-builder
                            :field="field"
                            :num="num"
                            :edited-item="editedItem"
                            :rules="rules"
                            :config="config"
                            @update="updateField($event)"
                          />
                        </template>
                        <div>
                          <slot :id="editedItem.id" name="files"></slot>
                        </div>
                        <slot :id="editedItem.id" name="subtable"></slot>
                      </v-form>
                    </slot>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-flex text-xs-left pa-4>
                <v-btn large color="primary" @click.prevent="onSave">
                  Сохранить
                </v-btn>
                <v-btn large color="red lighten-3" @click.native="onCancel">Отмена</v-btn>
              </v-flex>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-card v-if="headers.length > 0">
          <v-card-title>
            <slot name="title"></slot>
            <v-spacer></v-spacer>
            <v-text-field v-model="search" append-icon="search" label="Поиск" single-line hide-details></v-text-field>
          </v-card-title>
          <v-card-text>
            <v-data-table
              :headers="headerWithAction"
              :items="customItems ? customItems : items"
              :search="search"
              :loading="loading"
              :elevation="0"
              :items-per-page=15
              :footer-props="{
                itemsPerPageText: 'Строк на странице'
              }"
              class="elevation-0">
              <!--<template slot="headers" slot-scope="props">
                <tr>
                  <th
                    v-for="header in props.headers"
                    :key="header.text"
                    :class="['column sortable text-xs-left']"
                  >
                    <v-icon small>arrow_upward</v-icon>
                    {{ header.text }}
                  </th>
                  <th>Действия</th>
                </tr>
              </template>-->
              <template v-slot:body="{ items }">
                <tbody>
                <tr v-for="item in items" :class="{'is-edited': item.id == currentEditedId}" :key="item.id">
                  <td v-for="header in headers" :class="'text-xs-'+header.align">
                    <template v-if="header.value === 'active'">
                      <v-icon v-if="item.active" color="primary">done</v-icon>
                      <v-icon v-else color="pink">close</v-icon>
                    </template>
                    <template v-else>
                      {{item[header.value]}}
                    </template>
                  </td>
                  <!--<td class="text-xs-left">{{ props.item.id }}</td>
                  <td class="text-xs-left">{{ props.item.title }}</td>
                  <td class="text-xs-left">{{ props.item.sort }}</td>
                  <td class="text-xs-left">{{ props.item.active }}</td>-->
                  <slot name="content-table"></slot>
                  <td class="justify-center layout px-0">
                    <v-btn icon class="mx-0" @click="setEditedItem(item.id)">
                      <v-icon color="teal">edit</v-icon>
                    </v-btn>
                    <!--<v-btn :disabled="props.item.url_key === 'po-umolchaniyu'" icon class="mx-0"
                           @click="deleteItem(props.item)">
                      <v-icon color="pink">delete</v-icon>
                    </v-btn>-->
                  </td>
                </tr>
                </tbody>
              </template>
              <template v-if="loading" slot="no-data">
                <br>
                <v-progress-circular indeterminate :size="100" color="primary"></v-progress-circular>
                <br>
                <br>
              </template>
              <template v-if="!loading" slot="no-data">
                <v-alert :value="true" color="error" icon="warning">
                  Извините, нет данных для отображения :(
                </v-alert>
              </template>
              <v-alert slot="no-results" :value="true" color="error" icon="warning">
                По ключевой фразе "{{ search }}" ничего не найдено.
              </v-alert>
            </v-data-table>
          </v-card-text>
          <v-card-actions>
            <v-btn @click="onTouch({id: null})" color="primary" class="text-left mb-2">
              <v-icon>add</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
        <v-layout v-else justify-center align-center>
          <v-progress-circular indeterminate :size="100" color="primary"></v-progress-circular>
        </v-layout>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
  import {GLOBAL} from "@/constants";
  import FormBuilder from './FormBuilder'

  export default {
    name: 'LeaderTable',
    props: {
      module: {
        type: String,
        required: true
      },
      customHeaders: {
        type: Array,
        default: function () {
          return []
        }
      },
      customItems: {
        type: Array,
        default: function() {
          return null
        }
      }
    },
    mounted() {
      this.load()
    },
    computed: {
      hasFilesSlot() {
        return !!this.$slots['files']
      },
      config() {
        return this.$store.getters[this.module + '/config']
      },
      getItems2(num) {
        return this.$store.getters[this.config.upLinks.find(item => item.column === num).module+'/items']
      },
      items() {
        return this.$store.getters[this.module + '/items']
      },
      formFields() {
        return this.$store.getters[this.module + '/formFields']
      },
      headers() {
        return this.customHeaders.length > 0 ? this.customHeaders : this.$store.getters[this.module + '/headers']
      },
      headerWithAction() {
        return _.concat(this.headers, {
          text: 'Действия',
          align: 'center',
          sortable: false,
          value: 'id'
        })
      },
      loading() {
        return this.$store.getters[this.module + '/loading']
      },
      rules() {
        return this.$store.getters[this.module + '/rules']
      },
    },
    data() {
      return {
        search: null,
        dialog: false,
        isNew: false,
        isSending: false,
        editedItem: {},
        currentEditedId: null,
      }
    },
    components: {
      FormBuilder
    },
    methods: {
      async load() {
        const result = await this.$store.dispatch(this.module + '/' + GLOBAL.LOAD_ALL)
        if (result.length > 0) {
          this.$store.dispatch('files/'+GLOBAL.LOAD_BY_KEY, {fileable_type: this.$store.getters[this.module + '/config']['model'], fileable_id: result.map(item => item.id)})
        }
      },
      save(obj) {
        return this.$store.dispatch(this.module + '/' + GLOBAL.SAVE_DATA, obj)
      },
      del(id) {
        return this.$store.dispatch(this.module + '/' + GLOBAL.DELETE, id)
      },
      onTouch(obj) {
        this.isNew = true
        this.save(obj).then(response => {
          this.setEditedItem(response[0].id)
        })
      },
      onCancel() {
        if (this.isNew) {
          this.del(this.editedItem.id)
        }
        this.dialog = false
        this.isNew = false
      },
      async onSave() {
        let isValid = await this.$validator.validate()
        if (!isValid) {
          return
        }

        this.save(this.editedItem)
          .then(response => {
            this.dialog = false
            this.isNew = false
          })
          .catch(error => {
          })
      },
      setEditedItem(id) {
        this.currentEditedId = id
        this.editedItem = Object.assign({}, this.items.find(item => item.id == id))
        this.dialog = true
      },
      updateField(event) {
        Object.assign(this.editedItem, event)
      },
      getRules(num) {
        return !_.isUndefined(this.rules[num]) ? '' + this.rules[num] : ''
      },
      isEdited(id) {
        return id === this.currentEditedId
      }
    }
  }
</script>

<style scoped>
  .is-edited {
    background-color: #E0E0E0;
    color: black;
  }
</style>