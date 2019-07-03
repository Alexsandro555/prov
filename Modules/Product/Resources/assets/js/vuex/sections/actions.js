import {ACTIONS} from '@product/constants'
import {GLOBAL} from '@/constants'

export default {
  [ACTIONS.LOAD_SECTIONS]: ({commit, dispatch, getters}) => {
    return new Promise((resolve, reject) => {
      dispatch(GLOBAL.LOAD).then(response => {
        resolve()
      }).catch(error => {
        reject(error)
      })
    })
  }
}