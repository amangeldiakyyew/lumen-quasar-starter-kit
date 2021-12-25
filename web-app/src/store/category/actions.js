/*
import {api} from "boot/axios";

export function fetchCategories(ctx) {
  return new Promise((resolve, reject) => {
    api.get('/categories',{params:{with:['children']}}).then((response) => {
      ctx.commit('fetchCategories', response);
      resolve(response);
    }).catch((err) => {
      reject(err);
    });
  });
}

export function fetchCategory(ctx) {
}
*/
