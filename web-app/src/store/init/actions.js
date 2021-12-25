import {api} from "boot/axios";

export function fetchInitData(context, data = {platform: 'web'}) {
  return new Promise((resolve, reject) => {
    api.post('/init', data).then(function (response) {
      context.commit('setInitiated', true);
      context.commit('setSettings', response.data.settings);
      if (response.data.user){
        context.commit('auth/setAuth', response.data.auth, {root: true});
        context.commit('auth/setUser', response.data.user, {root: true});
      }
      context.commit('category/setCategories', response.data.categories, {root: true});
      resolve(response);
    }).catch(function (err) {
      reject(err);
    });
  });
}
