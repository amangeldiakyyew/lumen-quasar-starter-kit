import {api} from "boot/axios";

export async function register(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.post('/auth/register', data.credentials).then(response => {
      resolve(response);
    }).catch(err => {
      reject(err);
    });
  });
}

export function login(context, data) {
  return new Promise((resolve, reject) => {
    api.post('/auth/login', data.credentials).then(function (response) {
      context.commit('login', response);
      resolve(response);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function logout(context) {
  return new Promise((resolve, reject) => {
    api.post('/auth/logout', {}).then(function (response) {
      context.commit('logout', response);
      resolve(response);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function check(context) {
  return new Promise((resolve, reject) => {
    api.post('/auth/check').then(function (response) {
      context.commit('check', response);
      resolve(response);
    }).catch(function (err) {
      reject(err);
    }).finally(() => {
      context.commit('checked');
    });
  });
}
