<template>
  <div id="callback">
    <a v-if="visible" href="#" id="popup__toggle" @click="close"></a>
    <div :class="{callbackwindow: true, callbackhidden: !visible}">
      <div v-if="visible" id="btn-cllback" @click="close">&nbsp;</div>
      <div class="callback-form">

        <span class="callback-header">Обратный <span class="callback-subheader">звонок</span></span><br><br>
        <v-container dark fill-height pa-0 ma-0>
          <v-row class="no-gutters justify-start align-start">
            <v-col cols="12">
              <v-text-field
                name="fio"
                v-validate="'required'"
                data-vv-name="fio"
                label="*Ф.И.О."
                :error-messages="errors.first('fio')"
                solo
                v-model="form.fio">
              </v-text-field>
              <v-text-field
                name="telephone"
                v-validate="'required'"
                data-vv-name="telephone"
                :error-messages="errors.first('telephone')"
                label="*Телефон"
                solo
                v-model="form.telephone">
              </v-text-field>
              <v-textarea
                solo
                name="comment"
                label="Комментарий"
                placeholder="Комментарий"
                :error-messages="errors.first('comment')"
                v-model="form.comment">
              </v-textarea>
              <v-btn class="callback-btn" @click="send">Отправить</v-btn>
            </v-col>
          </v-row>
        </v-container>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  import {mapState} from 'vuex'
  
  export default {
    $_veeValidate: {
      validator: 'new',
    },
    computed: {
      ...mapState('callback', {visible: 'isVisible', form: 'form'})
    },
    methods: {
      async send() {
        let isValid = await this.$validator.validate()
        if (!isValid) {
          return
        }
        axios.post('/callback', this.form).then(response => {
          this.$store.commit('SET_VARIABLE_MODULE', {module: 'callback', variable: 'form', value: {}}, {root: true})
          this.$store.commit('SET_VARIABLE_MODULE', {module: 'callback', variable: 'isVisible', value: false})
        })
      },
      close() {
        this.$store.commit('SET_VARIABLE_MODULE', {module: 'callback', variable: 'form', value: {}}, {root: true})
        this.$store.commit('SET_VARIABLE_MODULE', {module: 'callback', variable: 'isVisible', value: false}, {root: true})
      }
    }
  }
</script>

