<template>
  <v-layout row wrap>
    <v-flex xs12>
      <v-layout row wrap>
        <v-flex xs7 class="hidden-md-and-down">
          <v-layout class="full-height" column justify-center align-start>
            <span class="headsite-low">Фильтр</span>
          </v-layout>
        </v-flex>
        <v-flex md5 xs12 text-xs-right>
          <v-layout row wrap>
            <v-flex xs6 shrink text-xs-rigth class="select">
              <v-layout align-baseline>
                <v-select :items="sortedElements" item-text="title" @change="selectOrder" autofocus item-value="id"
                          v-model="sortBy" single-line :append-icon="'$vuetify.icons.dropdown'">
                  <template slot="selection" slot-scope="data">
                    <v-icon>sort</v-icon>
                    <span class="select__text">&nbsp;{{data.item.title}}</span>
                  </template>
                </v-select>
              </v-layout>
            </v-flex>
            <v-flex xs6 pa-3 text-xs-right>
              <v-btn-toggle v-model="toggle_view" mandatory>
                <v-btn>
                  <v-icon>view_module</v-icon>
                </v-btn>
                <v-btn>
                  <v-icon>view_list</v-icon>
                </v-btn>
                <v-btn>
                  <v-icon>view_headline</v-icon>
                </v-btn>
              </v-btn-toggle>
            </v-flex>
          </v-layout>
        </v-flex>
      </v-layout>
    </v-flex>
    <v-flex xs12 class="filterBody">
      <aside v-if="attributes.length>0" class="filterSidebar hidden-md-and-down">
        <v-expansion-panel v-model="panel" expand>
          <v-expansion-panel-content class="collapseAttribute" v-for="attribute in attributes"
                                     :key="attribute.id">
            <template slot="header">
              <span class="collapseAttribute__header">{{attribute.title}}</span>
            </template>
            <v-card max-height="300" class="collapseAttribute__content">
              <v-card-title>
                <attributes :items="attribute.attribute_list_value" :checked="selectAttributesValues[attribute.id]"
                            @attributechanged="updateSelectedAttribute(attribute.id,$event)"/>
              </v-card-title>
            </v-card>
            <p></p>
          </v-expansion-panel-content>
        </v-expansion-panel>
        <v-card>
          <v-card-text>
            <v-layout row wrap>
              <v-flex xs2 text-xs-left>
                <v-icon @click="clearFilter" color="#28435c">refresh</v-icon>
              </v-flex>
              <v-flex xs10 text-xs-center><a href="#" class="clear" @click="clearFilter">Сбросить фильтр</a></v-flex>
            </v-layout>
          </v-card-text>
        </v-card>
      </aside>
      <v-flex xs12>
        <v-layout v-if="isLoading" row justify-center align-center>
          <v-progress-circular indeterminate :size="100" color="primary"></v-progress-circular>
        </v-layout>
        <v-layout v-else row wrap>
          <module-view :products="products" v-if="toggle_view==0"/>
          <list-view :products="products" :attributes="attributes" v-else-if="toggle_view==1"/>
          <table-view :products="products" :attributes="attributes" v-else/>
          <div @click.prevent="filterOpen" class="filter-mobile hidden-md-and-up">
            <v-container pa-0 fill-height>
              <v-layout row wrap justify-center align-center>
                <a class="filter-mobile__link text-xs-center" href="#">Фильтр продукции</a>
              </v-layout>
            </v-container>
          </div>
        </v-layout>
        <v-navigation-drawer v-model="drawer" temporary absolute style="position:fixed; top:0; left:0; overflow-y:scroll;">
          <div v-if="attributes.length>0" class="filterSidebar" style="margin-top: 60px; margin-bottom: 60px;">
            <v-expansion-panel v-model="panel" expand>
              <v-expansion-panel-content class="collapseAttribute" v-for="attribute in attributes"
                                         :key="attribute.id">
                <template slot="header">
                  <span class="collapseAttribute__header">{{attribute.title}}</span>
                </template>
                <v-card max-height="300" class="collapseAttribute__content">
                  <v-card-title>
                    <attributes :items="attribute.attribute_list_value" :checked="selectAttributesValues[attribute.id]"
                                @attributechanged="updateSelectedAttribute(attribute.id,$event)"/>
                  </v-card-title>
                </v-card>
                <p></p>
              </v-expansion-panel-content>
            </v-expansion-panel>
            <v-card>
              <v-card-text>
                <v-layout row wrap>
                  <v-flex xs2 text-xs-left>
                    <v-icon @click="clearFilter" color="#28435c">refresh</v-icon>
                  </v-flex>
                  <v-flex xs10 text-xs-center><a href="#" class="clear" @click="clearFilter">Сбросить фильтр</a></v-flex>
                </v-layout>
              </v-card-text>
            </v-card>
          </div>
        </v-navigation-drawer>
      </v-flex>
    </v-flex>
  </v-layout>
</template>

<script>
  import Attributes from './Attributes'
  import ModuleView from './View/Module'
  import ListView from './View/List'
  import TableView from './View/Table'
  import axios from 'axios'

  export default {
    name: 'FilterProducts',
    props: {
      modelId: {
        type: Number,
        required: true
      },
      modelColumnName: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        panel: [true, true, true],
        selectAttributesValues: {},
        sortedElements: [
          {id: 'sort|asc', title: 'По умолчанию'},
          {id: 'title|asc', title: 'По названию от А до Я'},
          {id: 'title|desc', title: 'По названию от Я до А'},
          {id: 'price|asc', title: 'Цена - по возрастанию'},
          {id: 'price|desc', title: 'Цена - по убыванию'}
        ],
        sortBy: 'sort|asc',
        toggle_view: 3,
        products: [],
        isLoading: false,
        countedAttributes: [],
        attributes: [],
        drawer: false
      }
    },
    mounted() {
      this.isLoading = true
      let params = 'sortBy=' + this.sortBy
      axios.get('/filter/' + this.modelId +'/'+this.modelColumnName + '?' + params)
        .then(response => response.data)
        .then(response => {
          this.products = response.products
          this.attributes = response.attributes
          this.isLoading = false
        })
        .catch(error => {
          this.isLoading = false
          console.log(error)
        })
    },
    components: {
      Attributes,
      ModuleView,
      ListView,
      TableView
    },
    watch: {
      selectAttributesValues(values) {
        this.sendRequest(values)
      }
    },
    methods: {
      selectOrder() {
        this.sendRequest(this.selectAttributesValues)
      },
      clearFilter() {
        this.sendRequest([]);
        for (let key in this.selectAttributesValues) {
          this.selectAttributesValues[key] = []
        }
      },
      filterOpen() {
        this.drawer = true
      },
      sendRequest(values) {
        let params = ''
        for (let key in values) {
          values[key].forEach((value, index, array) => {
            if (params !== '') params += '&'
            params += 'param_id' + key + '[]=' + value
          })
        }
        params += '&sortBy=' + this.sortBy

        this.isLoading = true
        axios.get('/filter/' + this.modelId +'/'+this.modelColumnName + '?' + params)
          .then(response => response.data)
          .then(response => {
            this.products = response.products
            this.attributes = response.attributes
            this.isLoading = false
          })
          .catch(error => {
            this.isLoading = false
            console.log(error)
          })
      },
      updateSelectedAttribute(attribute_id, event) {
        this.selectAttributesValues = Object.assign({}, this.selectAttributesValues, {[attribute_id]: event})
      }
    }
  }
</script>

<style scoped>

  .filterBody {
    display: flex;
    flex-direction: row;
    border-top: 1px solid #d3d4d6;
  }

  .filterSidebar {
    width: 285px;
    flex: 0 0 285px;
    margin-right: 20px;
    display: block;
  }

  .filterContent {
    flex: 1;
  }

  .collapseAttribute__header {
    font-weight: bold;
    font-size: 1.2em;
    font-family: 'Gilroy-ExtraBold', sans-serif;
  }

  .collapseAttribute__content {
    padding: 0 10px 20px;
    overflow-y: auto;
    margin-right: 30px;
  }

  .select {
    width: 302px;
  }

  .select__text {
    font-size: 1.2em;
  }

  .full-height {
    height: 100%;
  }

  .clear {
    text-decoration: none;
    color: #28435c;
  }

  .filter-mobile {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 100;
    border-radius: 0;
    width: 100%;
    height: 50px;
    background-color: #ea2433;
  }

  .filter-mobile__link {
    text-decoration: none;
    font-size: 1.3em;
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
  }
</style>