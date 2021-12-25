import {api} from "boot/axios";

export function fetchSettings(context, params = {}) {
  return new Promise((resolve, reject) => {
    api.get('/settings', {params}).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function updateSettings(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.put('/settings', data.formData).then(res => {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

