<template>
  <div class="custom-upload">
    <v-dialog persistent @keydown.esc="onCancel" v-model="dialog" max-width="1400px">
      <v-card>
        <v-card-title>
          <v-flex px-4 class="headline"><h3>Загрузка</h3></v-flex>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row class="justify-start align-start">
              <v-col cols="12">
                <div class="image-container">
                  <v-text-field name="alt" label="Название изображения" v-model="alt" :counter="255"></v-text-field>
                  <cropper v-if="original" classname="cropper" :src="original" :stencil-props="{aspectRatio: 16/9}" @change="change"></cropper>
                </div>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-container pa-5 fil-height>
            <v-row class="justify-start align-start">
              <v-col cols="12">
                <v-btn style="padding-left: 5px;" text-xs-left large color="primary" @click.prevent="onSave">Сохранить</v-btn>
              </v-col>
            </v-row>
          </v-container>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-container no-gutter pa-0 ma-0>
      <v-row class="justify-center align-center" style="height: inherit;">
        <v-form ref="form" lazy-validation v-model="valid">
          <input type="file" ref="image" @change="onUpload" style="display: none"/>
          <div @click="onShowWindow" class="custom-upload__button">
            <v-icon right dark>cloud_upload</v-icon>
          </div>
        </v-form>
      </v-row>
    </v-container>
  </div>
</template>
<script>
  import {Cropper} from 'vue-advanced-cropper'
  import axios from 'axios'

  export default {
    name: 'Custom-Uploader',
    props: {
      'url': {
        type: String,
        default: '/files/custom-upload'
      },
      'fileableId': {
        type: Number,
        required: true
      },
      'typeFiles' :  {
        type: Array,
        required: true
      },
      'model': {
        type: String,
        required: true
      }
    },
    data() {
      return {
        valid: false,
        dialog: false,
        original: null,
        modified: null,
        alt: null
      }
    },
    computed: {
      isModified() {
        return this.modified == null
      }
    },
    methods: {
      onShowWindow() {
        this.$refs.image.click()
      },
      onCancel() {
        this.original = null
        this.modified = null
        this.$refs.image.value = null
        this.dialog = false
      },
      change({coordinates, canvas}) {
        this.modified =  canvas.toDataURL()
      },
      onUpload() {
        if (this.$refs.form.validate()) {
          let obj = this.$refs.image
          if (navigator.userAgent.indexOf('MSIE') >= 1) { // IE
            this.url = obj.value
          } else {
            if (obj.files.length !== 0 && obj.files.item(0).type.indexOf('image') !== -1) {
              this.original = window.URL.createObjectURL(obj.files.item(0))
            }
          }
          this.dialog = true
        }
      },
      onSave() {
        axios.post(this.url, {
          'fileable_id': this.fileableId,
          'name_type_file': this.typeFiles[0],
          'fileable_type': this.model,
          'file': this.modified,
          'alt': this.alt
        }).then(response => {
          this.$store.dispatch('files/set', {items: response.data}, {root: true})
        }).catch(error => {
         console.error(error)
        }).finally(() => {
          this.original = null
          this.modified = null
          this.$refs.image.value = null
          this.dialog = false
        })
      }
    }
  }
</script>

<style scoped>
  .custom-upload {
    border: 5px solid #fff;
    height: 250px;
    padding: 40px;
  }

  .custom-upload__button {
    height: inherit;
  }

  .image-container {
    width: 1200px;
  }
</style>