import {route} from 'quasar/wrappers'
import {createRouter, createMemoryHistory, createWebHistory, createWebHashHistory} from 'vue-router'
import routes from './routes'

/*
 * If not building with SSR mode, you can
 * directly export the Router instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Router instance.
 */

export default route(function ({store}) {
  const createHistory = process.env.SERVER
    ? createMemoryHistory
    : (process.env.VUE_ROUTER_MODE === 'history' ? createWebHistory : createWebHashHistory)

  const Router = createRouter({
    scrollBehavior: () => ({left: 0, top: 0}),
    routes,
    history: createHistory(process.env.MODE === 'ssr' ? void 0 : process.env.VUE_ROUTER_BASE)
  });

  Router.beforeEach((to, from, next) => {
    let authenticated = store.state.auth.isLoggedIn;
    let requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    let disableOnAuth = to.matched.some(record => record.meta.disableOnAuth);
    if (requiresAuth) {
      if (!authenticated) {
        store.dispatch('auth/check').then((res) => {
          next();
        }).catch(() => {
          next({name: 'login'});
        })
      } else {
        next();
      }
    } else if (disableOnAuth) {
      if (authenticated) {
        next({name: 'home'});
      } else {
        next();
      }
    } else {
      next();
    }
  });

  return Router
});
