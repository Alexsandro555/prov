<template>
  <v-container>
    <v-layout align-center justify-center full-height wrap row>
      <v-flex>
        <v-card>
          <v-card-title>
            <h1>Загрузка продукции</h1>
          </v-card-title>
          <v-card-text>
            <v-flex xs12>
              <v-form ref="form" lazy-validation v-model="valid">
                <input type="file" ref="excel" @change="onUpload" style="display: none"/>
                <v-btn
                  :loading="loading"
                  :disabled="loading"
                  color="blue"
                  class="white--text"
                  @click="onShowWindow">
                  Загрузить
                  <v-icon right dark>cloud_upload</v-icon>
                </v-btn>
              </v-form>
            </v-flex>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
  import axios from 'axios'

  export default {
    props: {},
    data() {
      return {
        loading: false,
        valid: false,
        isSaving: false
      }
    },
    mounted() {
    },
    methods: {
      onShowWindow() {
        this.$refs.excel.click()
      },
      onUpload() {
        if (this.$refs.form.validate()) {
          this.loading = true
          let formData = new FormData()
          let file = this.$refs.excel
          formData.append("file", file.files[0])
          this.loading = true
          axios.post('/api/products/import', formData, {
            headers: {
              'Content-type': 'multipart/form-data'
            }
          })
            .then(response => response.data)
            .then(response => {
              this.loading = false
            }).catch(error => {
            console.error(error)
          })
        }
      },
    }
  }
</script>