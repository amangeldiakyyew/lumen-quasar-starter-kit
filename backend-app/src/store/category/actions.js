import {api} from "boot/axios";

export function fetchCategories(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.get('/categories', {params: data.params}).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function autocompleteCategories(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.get('/categories/autocomplete', {params: data.params}).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function fetchCategory(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.get('/categories/' + data.id, {params: data.params}).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function storeCategory(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.post('/categories/', data.formData).then(res => {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function updateCategory(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.put('/categories/' + data.id, data.formData).then(res => {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}

export function deleteCategory(context, data = {}) {
  return new Promise((resolve, reject) => {
    api.delete('/categories/' + data.id).then(function (res) {
      resolve(res);
    }).catch(function (err) {
      reject(err);
    });
  });
}
