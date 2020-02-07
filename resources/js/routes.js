import Login from '@auth/vue/Login'
import Registration from '@auth/vue/Registration'
import Admin from '@app/vue/Admin'

const requireModule = require.context("../../Modules/", true, /routes\.js$/);

let routes = [];

requireModule.keys().forEach(fileName => {
  routes = routes.concat(requireModule(fileName).default)
});


const ifNotAuthenticated = (to, from, next) => {
  if (!localStorage.getItem('user-token')) {
    next()
    return
  }
  next('/')
}

const ifAuthenticated = (to, from, next) => {
  if(!!localStorage.getItem('user-token')) {
    next()
    return
  }
  next('/login')
}


export const allRoutes = [
  {
    path:'/login',
    name: 'login',
    component: Login,
    beforeEnter: ifNotAuthenticated
  },
  {
    path: '/registration',
    name: 'registration',
    component: Registration
  },
  {
    path: '/',
    redirect: '/products',
    component: Admin,
    beforeEnter: ifAuthenticated,
    children: routes
  }
];

export default allRoutes;