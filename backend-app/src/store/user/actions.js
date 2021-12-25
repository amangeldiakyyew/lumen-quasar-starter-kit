import {api} from "boot/axios";

export function fetchUsers(context, params = {}) {
  return new Promise((resolve, reject) => {
    api.get('/users', {params}).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function fetchUser(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.get('/users/' + data.id).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function storeUser(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.post('/users/', data.formData).then(res => {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function updateUser(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.put('/users/' + data.id, data.formData).then(res => {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function deleteUser(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.delete('/users/' + data.id).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}
