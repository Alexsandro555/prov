import { set, toggle, setStorage } from './utils/vuex'

export default {
  setDrawer: set('drawer'),
  setImage: setStorage('image'),
  setColor: set('color'),
  toggleDrawer: toggle('drawer')
}