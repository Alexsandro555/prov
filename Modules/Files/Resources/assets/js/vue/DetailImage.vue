<template>
  <div>
      <div class="detail__image hidden-md-and-down">
        <v-container class="detail__image--container" v-if="loading" fill-height pa-0 ma-0>
          <v-row class="justify-center align-center no-gutter">
            <v-col cols="12">
              <v-progress-circular  indeterminate  style="vertical-align: middle" :size="100" color="primary"></v-progress-circular>
            </v-col>
          </v-row>
        </v-container>
        <template v-else>
          <div class="image-wrapper">
            <img v-if="curImage" :src="curImage"/>
            <img v-else src="/images/no-image.png"/>
          </div>
          <div v-if="items.length>0" class="thumbnails-slider">
            <carousel :perPage="4" :centerMode="true" :paginationEnabled="false" :navigationEnabled="false">
              <slide  v-for="item of items" :key="item.id">
                <v-container fill-height pa-0 ma-0>
                  <v-row class="justify-center align-center">
                    <v-col cols="12">
                      <img @click="selectSlide(item.id)"  :src="'/storage/'+item.file"/>
                    </v-col>
                  </v-row>
                </v-container>
              </slide>
            </carousel>
          </div>
        </template>
      </div>
      <v-container class="hidden-lg-and-up pa-0 ma-0">
        <v-row class="no-gutters">
          <v-col cols="12">
            <carousel :perPage="1" :centerMode="true">
              <slide v-for="item of mediumItems" :key="item.id">
                <v-container style="min-height: 240px;" pa-0 ma-0>
                  <v-row class="justify-center align-center no-gutters" style="min-height: 240px;">
                    <v-col cols="12" class="text-center">
                        <img :src="'/storage/'+item.file">
                    </v-col>
                  </v-row>
                </v-container>
              </slide>
            </carousel>
          </v-col>
        </v-row>
      </v-container>
  </div>
</template>
<script>
  import axios from 'axios'
  import {Carousel,Slide} from 'vue-carousel'

  export default {
    props: {
      url: String,
      stock: {
        Type: Boolean,
        default: false
      },
      id: {
        Type: Number,
        required: true
      }
    },
    data: function () {
      return {
        elements: [],
        items: [],
        mainItems: [],
        mediumItems: [],
        curImage: '',
        loading: true
      }
    },
    mounted() {
      axios.get(this.url).then(response => {
        this.elements = response.data
        response.data.forEach(element => {
          this.items.push({'id': element.id, 'file': element.config.files.small.filename});
          this.mainItems.push({'id': element.id, 'file': element.config.files.main.filename})
          if (element.config.files.mobile) {
            this.mediumItems.push({'id': element.id, 'file': element.config.files.mobile.filename})
          } else {
            this.mediumItems.push({'id': element.id, 'file': element.config.files.medium.filename})
          }
        });
        // TODO:: утсранить дублирование
        this.curImage = this.items.length > 0 ? '/storage/' + this.elements[0].config.files.main.filename : null
        this.loading = false
      }).catch(error => {
        this.loading = false
      });
    },
    components: {
      Carousel,
      Slide
    },
    methods: {
      selectSlide: function (id, event) {
        this.elements.forEach(element => {
          if (element.id === id) {
            if(element.figure.length > 0) {
              let config = {
                url: '/files/figure/'+element.id+'/'+'main'+'/'+this.id,
                method: 'GET',
                responseType: 'blob'
              }
              axios(config).then(response => {
                let reader = new FileReader();
                reader.readAsDataURL(response.data);
                reader.onload = () => {
                  this.curImage = reader.result;
                }
              }).catch(error => {
                console.log(error)
              })
            }
            // TODO:: устранить дублирование
            this.curImage = '/storage/' + element.config.files.main.filename;
          }
        });
      }
    }
  }
</script>

<style>

  .detail__image {
    width: 570px;
    min-height: 490px;
    margin-left: 10px;
    //background: url('#{$path}/product-corner.png') top left no-repeat;
    background-color: #ffffff;
    /*-webkit-clip-path: polygon(0% 0%, 100% 0%, 100% 90%, 50% 100%, 0% 90%);
    clip-path: polygon(0% 0%, 100% 0%, 100% 90%, 50% 100%, 0% 90%);*/
  }

  .image-wrapper {
    height: 350px;
    position: relative;
    display: table-cell;
    vertical-align: middle;
    width: inherit;
    background-color: #fff;
  }

  .image-wrapper img {
    margin: 0 auto;
    //border: 1px solid #eee;
    padding: 2px;
    background-color: #fff;
  }

  .detail__image-label {
    position: absolute;
    width: 134px;
    height: 46px;
    background-color: $color-blue;
    -webkit-clip-path: polygon(5% 0%, 100% 0%, 100% 100%, 5% 100%, 0% 50%);
    clip-path: polygon(5% 0%, 100% 0%, 100% 100%, 5% 100%, 0% 50%);
    margin-left: 210px;
    margin-top: 20px;
    z-index: 2000;
    font-family: $font-gilroy-extrabold;
    font-size: 2em;
    color: $color-white;
    text-transform: uppercase;
  }

  .thumbnails-slider {
    width: 100%;
    margin: 0 auto;
    display: inline-block;
    position:relative;
    padding-top: 10px;
    padding-down: 10px;
  }

  .detail__image--container {
    min-height: 420px;
  }
</style>
