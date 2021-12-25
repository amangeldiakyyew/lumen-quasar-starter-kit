import {api} from "boot/axios";

export function login(context, data={}) {
  return new Promise((resolve, reject) => {
    api.post('/auth/login', data.credentials).then(function (response) {
      context.commit('login', response.data);
      resolve(response);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function logout(context) {
  return new Promise((resolve, reject) => {
    api.post('/auth/logout', {}).then(function (response) {
      context.commit('logout', true);
      resolve(response);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function check(context) {
  return new Promise((resolve, reject) => {
    api.post('/auth/check').then(function (response) {
      context.commit('check',response.data);
      resolve(response);
    }).catch(function (err) {
      reject(err);
    });
  });
}
