import {store} from 'quasar/wrappers'
import {createStore} from 'vuex'
import auth from './auth'
import admin from './admin'
import user from './user'
import category from './category'
import information from './information'
import setting from './setting'
import country from './country'
import state from './state'

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Store instance.
 */

export default store(function (/* { ssrContext } */) {
  const Store = createStore({
    modules: {
      auth,
      admin,
      user,
      category,
      information,
      setting,
      country,
      state,
    },

    // enable strict mode (adds overhead!)
    // for dev mode and --debug builds only
    strict: process.env.DEBUGGING
  })

  return Store
})
