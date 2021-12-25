import {Notify} from 'quasar'
import helper from "src/helpers/helper";

export default {
  getMessage(val) {
    let message = false;
    if (helper.isObject(val)) {
      if (val.response) {
        if (val.response.data) {
          if (val.response.data.message) {
            message = val.response.data.message;
          }
        }
      } else if (val.data) {
        if (val.data.message) {
          message = val.data.message;
        } else {
          message='';
          for (let key in val.data) {
            if (val.data.hasOwnProperty(key)) {
              let responseValue = val.data[key];
              if (helper.isArray(responseValue)) {
                responseValue.forEach(function (item, index) {
                  message += item + "<br>";
                })
              }
            }
          }
        }
      } else if (val.message) {
        message = val.message;
      }
    } else {
      message = val;
    }
    return message;
  },
  success: function (val) {
    let message = this.getMessage(val);
    if (message) {
      Notify.create({
        type: 'positive',
        message: message,
      });
    }
  },
  info: function (val) {
    let message = this.getMessage(val);
    if (message) {
      Notify.create({
        type: 'info',
        message: message,
      });
    }
  },
  error: function (val) {
    let message = this.getMessage(val);
    if (message) {
      Notify.create({
        type: 'negative',
        message: message,
        html:true
      });
    }
  },
};
