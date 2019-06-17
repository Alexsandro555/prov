<template>
  <div>
    <a v-if="visible" href="#" id="popup__toggle" @click="close"></a>
    <!--Окно обратного звонка-->
    <div :class="{callbackwindow: true, callbackhidden: !visible}">
      <div v-if="visible" id="btn-cllback"
           @click="close">
        &nbsp;
      </div>
      <div class="callback-form">
        <br><br><br>
        <span class="callback-header">Форма обратной связи</span><br><br>
        <p>
          <input class="form-input-text" :value="form.fio" @input="errors.fio = ''; form.fio = $event.target.value"
                 type="text" placeholder=" *ФИО" name="fio"/>
          <span class="callback-error">{{errors.fio}}</span>
        </p>
        <p>
          <input class="form-input-text" :value="form.company_name"
                 @input="errors.company_name = ''; form.company_name = $event.target.value" type="text"
                 placeholder=" Название компании" name="company_name"/>
          <span class="callback-error">{{errors.company_name}}</span>
        </p>
        <p>
          <input class="form-input-text" :value="form.telephone"
                 @input="errors.telephone = ''; form.telephone = $event.target.value" type="text"
                 placeholder=" *Телефон" name="telephone"/>
          <span class="callback-error">{{errors.telephone}}</span>
        </p>
        <p>
          <input class="form-input-text" :value="form.email"
                 @input="errors.email = ''; form.email = $event.target.value" type="text" placeholder=" *Email"
                 name="email"/>
          <span class="callback-error">{{errors.email}}</span>
        </p>
        <p>
          <textarea class="form-input-textarea" :value="form.comment"
                    @input="errors.comment = ''; form.comment = $event.target.value" placeholder="Комментарий"
                    name="comment"></textarea>
        </p>
        <button @click="send" class="callback-sbmt">Отправить</button>
      </div>
    </div>
  </div>
</template>
<script>
  import {ValidationConvert} from '@initializer/vue/validations'
  import axios from 'axios'
  import {mapState} from 'vuex'


  export default {
    props: {},
    data: function () {
      return {
        isHidden: true,
        validationConvert: new ValidationConvert(),
        errors: {}
      }
    },
    computed: {
      ...mapState('callback', {visible: 'isVisible', form: 'form'})
    },
    methods: {
      send() {
        this.errors = {}
        this.validationConvert.ruleValidations({required: true, max: 50}).forEach(item => {
          let result = item(this.form.fio)
          if (result !== true) {
            this.errors = Object.assign({}, this.errors, {fio: result})
          }
          result = item(this.form.telephone)
          if (result !== true) {
            this.errors = Object.assign({}, this.errors, {telephone: result})
          }
        })
        this.validationConvert.ruleValidations({'regex': '^\\w+([.-]?\\w+)*@\\w+([.-]?\\w+)*(\\.\\w{2,3})+$'}).forEach(item => {
          let result = item(this.form.email)
          if (result !== true) {
            this.errors = Object.assign({}, this.errors, {email: result})
          }
        })
        if (_.isEmpty(this.errors)) {
          axios.post('/callback', this.form).then(response => {
            this.$store.commit('SET_VARIABLE', {module: 'callback', variable: 'form', value: {}})
          })
        }
      },
      close() {
        this.$store.commit('SET_VARIABLE', {module: 'callback', variable: 'isVisible', value: false})
        this.$store.commit('SET_VARIABLE', {module: 'callback', variable: 'form', value: {}})
      }
    }
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/callback.scss'
</style>