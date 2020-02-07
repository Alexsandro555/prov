import {PRIVATE, GLOBAL} from '@/constants.js'
import { api } from '@/api/main.js'
import Vue from 'vue'

export default {
  async [GLOBAL.LOAD_ALL]({state, commit, getters, dispatch})
  {
    if (state[getters.config.loading] || getters.config.load_all || (state.items.length > 0 && state.items.length == state.count)) return state.items

    commit('SET_VARIABLE', {variable: getters.config.loading ,value:true})
    try {
      const data = await api.get(getters.config.load)
      dispatch('set',data)
      let upLoad=dispatch('loadUpLink',data.items)
      Promise.all([upLoad]).then(values => {
        commit('SET_VARIABLE', {variable: getters.config.loading ,value:false})
      }).catch(error => {
        commit('SET_VARIABLE', {variable: getters.config.loading ,value:false})
      })
      return data.items
    } catch (error) {
      commit('SET_VARIABLE', {variable: getters.config.loading ,value:false})
    }
  },
  [GLOBAL.LOAD_BY_KEY]: ({ dispatch, commit, getters, rootGetters },key) => {
    return new Promise((resolve, reject) => {
      if (_.isArray(key)||!_.isObject(key))
      {
        if (!_.isArray(key)) {key=[key]}
        var keyUniqNotNil=getters.emptyKeys(key)
        var obj = {};
        obj[getters.primary_key] = keyUniqNotNil;
        if (obj[getters.primary_key].length>0)
        {
          axios.post(getters.config.load,obj).then(response => {
            dispatch('set',response.data)
            var upLoad=dispatch('loadUpLink',getters.getByKey(getters.uniqNotNil(key)))
            Promise.all([upLoad]).then(values => {
              resolve(response.data.items)
            })
          })
        } else {resolve(getters.getByKey(getters.uniqNotNil(key)))}
      } else {obj=key
        if (!_.isEmpty(obj))
        {
          axios.post(getters.config.load,obj).then(response => {
            dispatch('set',response.data)
            var upLoad=dispatch('loadUpLink',response.data.items)
            Promise.all([upLoad]).then(values => {
              resolve(response.data.items)
            })
          })
        } else {resolve([])}
      }
    })
  },
  [GLOBAL.LOAD_DEEP]: ({ dispatch, commit, getters, rootGetters }, objects) => {
    return new Promise((resolve, reject) => {
      getters.config.downLinks.forEach(down => {
        var column = down.column
        var obj = {}
        obj[column] = objects.map(item => item[getters.config.primary_key])
        obj['__module'] = down.module
        dispatch(down.module+'/loadDeepHelper', obj, { root: true })
      })
    })
  },
  loadDeepHelper: ({dispatch, commit, getters, rootGetters}, objects) => {
    var module_name = objects['__module']
    delete objects['__module']
    dispatch(module_name+'/'+GLOBAL.LOAD_BY_KEY, objects, { root: true }).then(elements => {
      if (!_.isArray(elements)) { elements = [elements] }
      if (elements.length>0) dispatch(module_name+'/'+GLOBAL.LOAD_DEEP, elements, { root: true })
    })
  },
  [GLOBAL.ADD]: ({ commit, state, getters }, data) => {
    return new Promise((resolve, reject) => {
      api.post(getters.config.load+'/default', data).then(response => {
        commit('UPDATE_ARRAY_BY_KEY',{module:getters.config.module,variable:getters.config.items,key:getters.config.primary_key,value:response}, { root: true })
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },
  [GLOBAL.SAVE_DATA]: ({ commit, dispatch, state, getters }, data) => {
    return new Promise((resolve, reject) => {
      api.patch({data, url: getters.config.load}).then(response => {
        if (!_.isArray(response) && _.isObject(response)) {
          response = [response]
        }
        commit('UPDATE_ARRAY_BY_KEY',{module:getters.config.module,variable:getters.config.items,key:getters.config.primary_key,value:response}, { root: true })
        dispatch('successSaveNotification', response.message, {root: true})
        resolve(response)
      }).catch(error => {
          reject(error)
      })
    })
  },
  [GLOBAL.TOGGLE]: ({commit, dispatch, state, getters}, {data, module}) => {
    return new Promise((resolve, reject) => {
      api.patch({data, url: getters.config.load+'/toggle'}).then(response => {
        if (!_.isArray(response) && _.isObject(response)) response = [response]
        dispatch(module+'/moduleStateToggle' ,{ data: response.map(item => item.pivot), attributable_id: data.id, attributable_type: getters.getModel}, {root:true})
        dispatch('successSaveNotification', response.message, {root: true})
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },
  moduleStateToggle: ({commit, dispatch, state, getters}, {data, attributable_id, attributable_type}) => {
    let result = getters.items.filter(item => !(item.attributable_type == attributable_type && item.attributable_id == attributable_id)).concat(data)
    commit('SET_ARRAY_VARIABLE', {variable: getters.config.items, value: result})
  },
  [GLOBAL.DELETE]: ({ commit, state, getters, dispatch }, id) => {
    api.delete({url: getters.config.load, id})
      .then(response => {
        dispatch('successSaveNotification', 'Успешно удалено!', {root: true})
        commit(PRIVATE.DELETE, response)
      })
  },
  [GLOBAL.SAVE_DATA_MULTI]: ({ commit, dispatch, state }, data) => {
    return new Promise((resolve, reject) => {
      api.patch({data, url: state.url}).then(response => {
        dispatch('successSaveNotification', response.message, {root: true})
        response.forEach(element => {
          const isUpdated = state.items.find(item => item.id == element.id)
          if (isUpdated) {
            commit(GLOBAL.UPDATE, element)
          } else {
            commit(PRIVATE.ADD, element)
          }
        })
        resolve(response)
      })
    }).catch(error => {
      reject(error)
    })
  },
  loadUpLinkAll: ({commit, getters, dispatch, rootState}, items=[]) => {
    var upLinkReady=[];
    return new Promise((resolve) => {
      for (var index in getters.config.upLinks) {
        upLinkReady[index]=dispatch(getters.config.upLinks[index].module+'/loadAllRelationsIfNotExists',null, {root:true})
      }
      Promise.all(upLinkReady).then(values => {
        resolve(values)
      })
    })
  },
  loadUpLink: ({ dispatch, commit, getters, rootGetters },items=[]) => {
    var upLinkReady=[];
    return new Promise((resolve, reject) => {
      if (getters.config.upLinks.length === 0) resolve([])
      for (var index in getters.config.upLinks) {
        upLinkReady[index]=dispatch(getters.config.upLinks[index].module+'/loadIfNotExist',items.map(item => _.get(item,getters.config.upLinks[index].column)),{root:true})
      }
      Promise.all(upLinkReady).then(values => {
        resolve(values)
      })
    })
  },
  async ['loadAllRelationsIfNotExists']({dispatch, commit, getters, rootGetters}) {
    try{
      if(!getters.items.length>0 && !getters.loading) {
        commit('SET_VARIABLE', {variable: getters.config.loading ,value:true})
        const data = await api.get(getters.config.load)
        dispatch('set',data)
        commit('SET_VARIABLE', {variable: getters.config.loading ,value:false})
        var upLoad=dispatch('loadUpLinkAll',data.items)
        Promise.all([upLoad]).then(values => {
          return values
        })
      } else {
        return getters.items
      }
    } catch (error) {
      commit('SET_VARIABLE', {variable: getters.config.loading ,value:false})
    }
  },
  async ['loadIfNotExist']({ dispatch, commit, getters, rootGetters },key) {
    try {
      if (!_.isArray(key)) {key=[key]}
      let  cuttedKey=key.filter(item => !getters.items.map(newitem => newitem[getters.primary_key]).includes(item))

      if (getters.emptyKeys(cuttedKey).length>0) {
        var obj={};
        obj[getters.primary_key] = getters.emptyKeys(cuttedKey)
        let data = await api.post(getters.config.load, obj)
        dispatch('set',data)

        var upLoad=dispatch('loadUpLink',data.items)
        Promise.all([upLoad]).then(values => {
          return key.map(item => getters.getByKey(item))
        })
      } else {
        return key.map(item => getters.getByKey(item))
      }
    } catch (error) {}
  },
  set: ({state, dispatch, commit, getters, rootGetters }, { items=[], rules=null, relations={}, fields=null, count=0 }) => {
    if(!_.isArray(items)) {
      items = [items]
    }

    if (items.length>0) {
      commit('UPDATE_ARRAY_BY_KEY',{ module:getters.config.module, variable:getters.config.items, key:getters.config.primary_key, value:items}, { root: true })
    }

    commit('SET_VARIABLE',{ variable:'rules', value:rules })
    commit('SET_RELATIONS',relations)
    commit('SET_VARIABLE',{ variable:'formFields', value:fields })
    commit('SET_VARIABLE', { variable: 'count', value: count })
    for(let index in state.up) {
      if (state.formFields[state.up[index].column])
        Vue.set(state.formFields[state.up[index].column], 'type', 'selectbox')
    }
  }
}