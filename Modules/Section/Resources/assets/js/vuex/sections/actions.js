import axios from "axios";

export default {
  'setSection': ({commit, state, getters},data) => {
    axios.post('/sections/set', data)
      .then(response => response.data)
      .then(response => {
        localStorage.setItem('section', response)
        commit('SET_VARIABLE', {variable: 'current' ,value:response})
        window.location.reload()
      }).catch(error => {
      commit('SET_VARIABLE', {variable: 'current' ,value:null})
    })
  }
}