<template>
  <div>
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
        label="Название компании"
        v-model="form.telephone"
        :counter="15"
        :rules="getRules({required: true, max: 15})"
        :error-messages="messages.telephone">
      </v-text-field>
      <v-text-field
        name="email"
        label="Email"
        v-model="form.email"
        :counter="15"
        :rules="getRules({required: true, max: 15})"
        :error-messages="messages.email">
      </v-text-field>
    </v-form>
  </div>
</template>
<script>
  import {ValidationConvert} from '@/vue/Validations'

  export default {
    props: {},
    data() {
      return {
        valid: false,
        form: {}
      }
    },
    mounted() {
    },
    methods: {
      getRules(validations) {
        return validations ? this.validationConvert.ruleValidations(validations) : []
      }
    }
  }
</script>