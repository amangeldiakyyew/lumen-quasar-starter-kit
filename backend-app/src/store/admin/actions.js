import {api} from "boot/axios";

export function fetchAdmins(context, params = {}) {
  return new Promise((resolve, reject) => {
    api.get('/admins', {params}).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function fetchAdmin(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.get('/admins/' + data.id).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function storeAdmin(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.post('/admins/', data.formData).then(res => {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function updateAdmin(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.put('/admins/' + data.id, data.formData).then(res => {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function deleteAdmin(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.delete('/admins/' + data.id).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}
