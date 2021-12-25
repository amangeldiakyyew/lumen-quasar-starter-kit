import {api} from "boot/axios";

export function fetchCountries(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.get('/countries', {params:data.params}).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function fetchCountry(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.get('/countries/' + data.id).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function storeCountry(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.post('/countries/', data.formData).then(res => {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function updateCountry(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.put('/countries/' + data.id, data.formData).then(res => {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function deleteCountry(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.delete('/countries/' + data.id).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}
