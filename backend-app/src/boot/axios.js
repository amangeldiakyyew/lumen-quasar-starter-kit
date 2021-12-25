import {boot} from 'quasar/wrappers'
import axios from 'axios'
import storageHelper from "src/helpers/storageHelper";
import notifyHelper from "src/helpers/notifyHelper";
import {CONSTANTS} from "boot/constants";

const api = axios.create({baseURL: CONSTANTS.baseApiUrl});

export default boot(({app, router}) => {

  api.interceptors.request.use(
    config => {
      if (storageHelper.getToken()) {
        config.headers['Authorization'] = 'Bearer ' + storageHelper.getToken();
      }
      return Promise.resolve(config);
    },
    error => {
      return Promise.reject(error);
    }
  );

  api.interceptors.response.use(
    (response) => {
      return response;
    },
    (error) => {
      if (error.response.status === 422) {
        if (error.response) {
          notifyHelper.error(error.response);
        }
      }
      if (error.response.status === 401) {
        router.push({name: 'login'})
      }
      return Promise.reject(error);
    }
  );


  // for use inside Vue files (Options API) through this.$axios and this.$api

  app.config.globalProperties.$axios = axios
  // ^ ^ ^ this will allow you to use this.$axios (for Vue Options API form)
  //       so you won't necessarily have to import axios in each vue file

  app.config.globalProperties.$api = api
  // ^ ^ ^ this will allow you to use this.$api (for Vue Options API form)
  //       so you can easily perform requests against your app's API
})

export {api}
