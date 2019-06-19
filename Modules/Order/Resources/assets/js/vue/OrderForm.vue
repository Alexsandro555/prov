<template>
  <div class="order-form">
    <v-alert v-if="messages.emptyCart" type="error" :value="true">
      {{messages.emptyCart}}
    </v-alert>
    <v-form ref="form" lazy-validation v-model="valid">
      <v-text-field
        name="fio"
        label="ФИО"
        v-model="form.fio"
        :counter="255"
        :rules="getRules({required: true, max: 255})"
        :error-messages="messages.fio"
        required>
      </v-text-field>
      <v-text-field
        name="company_name"
        label="Название компании"
        v-model="form.company_name"
        :counter="255"
        :rules="getRules({max: 255})"
        :error-messages="messages.company_name">
      </v-text-field>
      <v-text-field
        name="company_name"
        label="Телефон"
        v-model="form.telephone"
        :counter="15"
        :rules="getRules({required: true, max: 15})"
        :error-messages="messages.telephone">
      </v-text-field>
      <v-text-field
        name="email"
        label="Email"
        v-model="form.email"
        :counter="50"
        :rules="getRules({required: true, max: 50})"
        :error-messages="messages.email">
      </v-text-field>
      <v-textarea
        name="note"
        label="Примечание"
        v-model="form.note"
        :error-messages="messages.note">
      </v-textarea>
      <v-flex xs2>
        <v-btn text-xs-left
               large
               :class="{primary: valid, 'red': !valid}"
               :disabled="isSending"
               @click.prevent="onSubmit">
          Заказать
        </v-btn>
      </v-flex>
    </v-form>
  </div>
</template>
<script>
  import { ValidationConvert } from '@/vue/Validations'
  import { mapState } from 'vuex'
  import axios from 'axios'

  export default {
    props: {},
    data() {
      return {
        valid: false,
        isSending: false,
        form: {},
        validationConvert: new ValidationConvert(),
      }
    },
    computed: {
      ...mapState('initializer', ['messages']),
    },
    mounted() {
    },
    methods: {
      getRules(validations) {
        return validations ? this.validationConvert.ruleValidations(validations) : []
      },
      onSubmit() {
        if (this.$refs.form.validate()) {
          this.isSending = true
          axios.post('/order', this.form)
            .then(response => response.data)
            .then(response => {
              window.location.href = '/order/'+response.number
            })
            .catch(error => {
              this.isSending = false
          })
        }
      },
    }
  }
</script>

<style scoped>
  .order-form {
    width: 100%;
  }
</style>