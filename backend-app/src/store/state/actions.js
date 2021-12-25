import {api} from "boot/axios";

export function fetchStates(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.get('/states', {params: data.params}).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function fetchState(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.get('/states/' + data.id, {params: data.params}).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function storeState(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.post('/states/', data.formData).then(res => {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function updateState(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.put('/states/' + data.id, data.formData).then(res => {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function deleteState(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.delete('/states/' + data.id).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}
