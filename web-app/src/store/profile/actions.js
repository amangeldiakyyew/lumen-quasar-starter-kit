import {api} from "boot/axios";

export function update(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.put('/profile', data.user).then(function (response) {
      context.commit('auth/setUser', response.data.user, {root: true});
      resolve(response);
    }).catch(function (err) {
      reject(err);
    });
  });
}
