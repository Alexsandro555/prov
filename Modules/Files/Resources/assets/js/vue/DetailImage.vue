<template>
  <div class="detail__image--wrapper">
      <div v-if="stock" class="detail__image-label">
        Акция!
      </div>
      <div class="detail__image">
        <v-container v-if="loading" fill-height>
          <v-layout row wrap align-center>
            <v-flex class="text-xs-center">
              <v-progress-circular  indeterminate  style="vertical-align: middle" :size="100" color="primary"></v-progress-circular>
            </v-flex>
          </v-layout>
        </v-container>
        <template v-else>
          <div class="image-wrapper">
            <img v-if="curImage" :src="curImage"/>
            <img v-else src="/images/no-image.png"/>
          </div>
          <div v-if="items.length>0" class="thumbnails-slider">
            <carousel :items="3" :nav="false" :dots="false" :margin="5">
              <div  v-for="item of items" :key="item.id">
                <v-container fill-height>
                  <v-layout row wrap align-center>
                    <v-flex class="text-xs-center">
                      <img @click="selectSlide(item.id)"  :src="'/storage/'+item.file"/>
                    </v-flex>
                  </v-layout>
                </v-container>
              </div>
              <template slot="prev"><img class="nav-arrow-left" src="/images/slider-left-arrow.png"/></template>
              <template slot="next">
                <img  align="center" class="nav-arrow-right" src="/images/slider-right-arrow.png"/></template>
            </carousel>
          </div>
        </template>
      </div>
  </div>
</template>
<script>
  import axios from 'axios'
  import carousel from 'vue-owl-carousel'

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
        curImage: '',
        loading: true
      }
    },
    mounted() {
      axios.get(this.url).then(response => {
        this.elements = response.data
        response.data.forEach(element => {
          this.items.push({'id': element.id, 'file': element.config.files.small.filename});
        });
        // TODO:: утсранить дублирование
        this.curImage = this.items.length > 0 ? '/storage/' + this.elements[0].config.files.main.filename : null
        this.loading = false
      }).catch(error => {
        this.loading = false
      });
    },
    components: {
      carousel
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

