<template>
  <v-container>
    <v-layout wrap row>
      <v-flex v-if="form">
        <v-card>
          <v-card-title>
            <h1>Редактирование изображения {{type}}</h1>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-layout row wrap>
                <v-flex>
                  <v-form ref="form" v-if="form && getItem(Number(id))" lazy-validation v-model="valid">
                    <v-flex text-xs-left>
                      <div class="white" :style="'width: '+this.getItem(Number(id))['config']['files'][this.type]['width']+'px'">
                        <v-alert type="success" :value="form.x && form.y">Выбранные координаты {{form.x}}, {{form.y}}</v-alert>
                        <v-alert type="error"  :value="!form.x">Выберите месторасположение</v-alert>
                        <img v-if="image" @click="getCoordinates" :src="this.curImage"/><br>
                      </div>
                      <v-autocomplete
                        v-model="form.attribute_id"
                        :items="attributes"
                        :search-input.sync="searchAttribute"
                        color="white"
                        hide-no-data
                        item-text="title"
                        item-value="id"
                        label="Атрибут"
                        placeholder="Введите название атрибута для поиска"
                        required>
                      </v-autocomplete>
                      <v-slider
                        name="degree"
                        v-model="form.degree"
                        label="Градус поворота против часовой стрелки"
                        thumb-label="always"
                        :max="360"
                        :min="0"
                        required></v-slider>
                      Цвет текста:<br>
                      <color-picker v-model="form.color"/>
                      <v-btn text-xs-left large :class="{primary: valid, 'red lighten-3': !valid}" :disabled="isSending" @click.prevent="onSubmit">Сохранить</v-btn>
                    </v-flex>
                  </v-form>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
  import {mapActions, mapState, mapMutations, mapGetters} from 'vuex'
  import {GETTERS} from '@product/constants'
  import {ACTIONS, GLOBAL} from '@/constants'
  import { Compact } from 'vue-color'
  import axios from 'axios'

  export default {
    props: {
      id: {
        type: String,
        required: true
      },
      type: {
        type: String,
        required: true
      }
    },
    data: function () {
      return {
        valid: false,
        isSending: false,
        defaultForm: this.getDefaultForm(),
        form: this.getDefaultForm(),
        searchAttribute: '',
        curImage: ''
      }
    },
    mounted() {
      this.loader = false
      this.init(this.id)
    },
    computed: {
      image() {
        return this.getItem(Number(this.id))
      },
      ...mapGetters('files', {getItem: GLOBAL.GET_ITEM, getModel: 'getModel'}),
      ...mapState('attributes', {attributes: 'items'})
    },
    components: {
      'color-picker': Compact,
    },
    methods: {
      getDefaultForm() {
        return {
          attribute_id: null,
          x: null,
          y: null,
          degree: null,
          color: {
            rgba: {
              a: 1,
              b: 63,
              g: 30,
              r: 31
            }
          }
        }
      },
      init(id) {
        if (!this.getItem(Number(id))) {
          this.$router.push({name: 'images'})
        } else {
          this.getImage()
        }
      },
      getCoordinates(event) {
        this.form.x = event.offsetX
        this.form.y = event.offsetY
      },
      getImage() {
        let config = {
          url: '/files/figure/'+this.id+'/'+this.type,
          method: 'GET',
          responseType: 'blob'
        }
        axios(config).then(response => {
          console.log(response)
          let reader = new FileReader();
          reader.readAsDataURL(response.data);
          reader.onload = () => {
            this.curImage = reader.result;
          }
        }).catch(error => {
          console.log(error)
        })
      },
      onSubmit() {
        if (this.$refs.form.validate()) {
          this.isSending = true
          let request = Object.assign({}, this.form, {file_id: Number(this.id), type: this.type})
          axios.post('/api/files', request).then(response => {
            this.getImage()
            this.form = Object.assign({}, this.defaultForm)
            this.isSending = false
          }).catch(error => {
            this.isSending = false
          })
        }
      }
    }
  }
</script>