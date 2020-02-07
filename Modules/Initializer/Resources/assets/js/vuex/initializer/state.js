import axios from 'axios'
//import router from '@/main_router.js'

export default {
  namespaced: true,
  state: {
    messages: {},
    message: '',
    darkColor: true
  },
  actions: {
    init({commit, dispatch}) {
      const token = localStorage.getItem('user-token')
      if (token) {
        axios.defaults.headers.common['Authorization'] = 'Bearer '+token
      }
      axios.interceptors.response.use(response => {
          return response;
        },
        error => {
          let errorType = error.response.status
          switch (errorType) {
            case 413:
              dispatch('errorNotification', 'Ошибка сервера 413 обратитесь к системному администратору', {root: true})
            case 419:
              //router.push({name: 'login'})
              break;
            case 401:
              commit('SET_ERROR', error.response.data.error)
              localStorage.removeItem('user-token')
             //router.push({name: 'login'});
              break;
            case 422:
              commit('SET_ERRORS', error.response.data.errors)
              break;
            default:
              dispatch('errorNotification', error.response.data.message, {root: true})
          }
          return Promise.reject(error.response);
        })
    },
    handleError({commit, dispatch}, error) {
      let errorType = error.status
      switch (errorType) {
        case 413:
          dispatch('errorNotification', 'Ошибка сервера 413 обратитесь к системному администратору', {root: true})
          break;
        case 419:
          break;
        case 401:
          commit('SET_ERROR', error.response.message)
          localStorage.removeItem('user-token')
          break;
        case 422:
          commit('SET_ERRORS', error.response.message)
          let messages = '';
          let response = JSON.parse(error.response)
          for(let index in response.errors) {
            response.errors[index].forEach(message => {
              messages = messages+' '+index+': '+message
            })

          }
          dispatch('errorNotification', 'Сбой валидации: '+messages, {root: true})
          break;
        case 404:
          dispatch('errorNotification', 'Ошибка сервера 404 '+error.response.message+' обратитесь к системному администратору', {root: true})
          break;
        default:
          dispatch('errorNotification', error.response.data.message, {root: true})
      }
      return Promise.reject(error);
    },
    resetError({commit}) {
      commit('RESET_ERROR')
    },
    socket_ObjectSaved({dispatch, commit, getters, rootGetters}, {object, module, variable, key}) {
      commit('UPDATE_ARRAY_BY_KEY', {module: module, variable: variable, value: object, key: key}, {root: true})
    }
  },
  getters: {},
  mutations: {
    SET_ERROR: (state, payload) => {
      state.message = payload
    },
    SET_ERRORS: (state, payload) => {
      state.messages = Object.assign({}, payload)
    },
    RESET_ERROR: (state) => {
      state.messages = {}
      state.message = ''
    }
  }
}