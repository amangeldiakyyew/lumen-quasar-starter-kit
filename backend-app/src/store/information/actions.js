import {api} from "boot/axios";

export function fetchInformation(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.get('/information', {params: data.params}).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function fetchSingleInformation(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.get('/information/' + data.id, {params: data.params}).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function storeInformation(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.post('/information/', data.formData).then(res => {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function updateInformation(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.put('/information/' + data.id, data.formData).then(res => {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function deleteInformation(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.delete('/information/' + data.id).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}
