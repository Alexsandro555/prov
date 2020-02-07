<template>
  <v-container fluid fill-height>
    <v-layout justify-center align-center>
      <v-dialog
        v-model="dialog"
        max-width="600"
        persistent
      >
        <v-card :dark="darkColor" width="600px">
          <v-responsive height="100px" class="header">
            <v-flex xs11 offset-xs1 class="left">
              <br>
              <span class="display-1">Вход</span>
            </v-flex>
          </v-responsive>
          <v-card-title>
            <v-flex xs12>
              <v-alert v-if="errorMessage" type="error" :value="true">
                {{errorMessage}}
              </v-alert>
              <v-form ref="form" lazy-validation v-model="valid">
                <v-text-field
                  name="email"
                  label="E-mail"
                  v-model="form.email"
                  :rules="emailRules"
                  :counter="255"
                  required
                ></v-text-field>

                <v-text-field
                  name="password"
                  label="Пароль"
                  :append-icon="e3 ? 'visibility' : 'visibility_off'"
                  @click:append="() => (e3 = !e3)"
                  :type="e3 ? 'password' : 'text'"
                  min="8"
                  v-model="form.password"
                  :rules="passwordRules"
                  :counter="255"
                  required
                ></v-text-field>
              </v-form>
            </v-flex>
          </v-card-title>
          <v-card-actions>
            <v-btn color="blue darken-4" dark @click="onLogin">Войти</v-btn>
            <v-btn color="blue lighten-1" dark @click="$router.push({name: 'registration'})">Регистрация</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </v-container>
</template>
<script>
  import {ACTIONS} from '@auth/constants'
  import {mapState, mapMutations, mapActions} from 'vuex'

  export default {
    props: {},
    data: function () {
      return {
        dialog: true,
        e3: true,
        valid: false,
        form: {
          email: '',
          password: '',
        },
        emailRules: [
          v => !!v || 'E-mail обязательный для заполнения',
          v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail должен иметь правильный формат'
        ],
        passwordRules: [
          v => !!v || 'Пароль обязательный для заполнения',
          v => !!v && v.length >= 8 || 'Пароль должен иметь не менее 8 символов'
        ],
        flagError: false,
        arrErrors: [],
        resultMessage: '',
        show: true
      }
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {vm.resetError()})
    },
    computed: {
      ...mapState('initializer', {errorMessage: 'message'}),
      ...mapState('initializer', ['darkColor']),
    },
    methods: {
      ...mapMutations('Auth', {setState: 'SET_VARIABLE'}),
      ...mapMutations('initializer', {resetError: 'RESET_ERROR'}),
      ...mapActions('Auth', {login: ACTIONS.LOGIN}),
      onLogin() {
        if (this.$refs.form.validate()) {
          this.login(this.form).then(response => {
            this.$refs.form.reset()
            this.resetError()
            this.$router.push({name: 'Продукция'})
          })
        }
      }
    }
  }
</script>

<style scoped>
  .header {
    background-color: #0e47a1;
    text-transform: uppercase;
  }

  /*.error--text {
    color: red !important;
  }*/
</style>