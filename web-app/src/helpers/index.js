import {Notify, date} from 'quasar'
import {i18n} from "boot/i18n";
const $t = i18n.global.t;
const $tm = i18n.global.tm;

export default Object.freeze({
  createCategoryCaption: function (categoryChildren) {
    let text = '';
    for (let key in categoryChildren) {
      let textItemEnd = '';
      if (key + 1 === categoryChildren.length) {
        textItemEnd = ' ...';
      } else {
        textItemEnd = ', ';
      }
      text += categoryChildren[key].name + textItemEnd;
    }
    return text;
  },
  image(obj, onlySrc = true) {
    let key = Object.keys(obj).reduce(function (r, a, i) {
      return !i || +obj[a] < +obj[r] ? a : r;
    }, undefined);
    if (obj[key]) {
      return obj[key].s
    }
    return obj;
  },
  errorMessageObjToText(responseObj) {
    let message = '';
    for (let key in responseObj) {
      if (responseObj.hasOwnProperty(key)) {
        let responseValue = responseObj[key];
        if (this.isArray(responseValue)) {
          responseValue.forEach(function (item, index) {
            message += item + '<br>';
          })
        } else {
          message += responseValue + '<br>';
        }
      }
    }
    return message;
  },
  formatDate(d, f = 'DD.MM.YYYY HH:mm ') {
    return date.formatDate(d, f, $tm('DATE'));
  },
  isArray(obj) {
    return Object.prototype.toString.call(obj) === '[object Array]';
  },
  isObject(data) {
    return typeof data === 'object' && data !== null;
  },
  editorToolbarSetting: [
    ['bold', 'italic', 'underline', 'link'],
    [
      {
        label: $t('editorAlign'),
        icon: 'format_align_left',
        options: ['left', 'center', 'right', 'justify']
      }
    ],
    [
      {
        label: $t('editorFormatting'),
        icon: 'title',
        options: ['p', 'h3', 'h4', 'h5', 'h6', 'code']
      },
      {
        label: 'Font',
        icon: 'text_format',
        fixedIcon: true,
        list: 'no-icons',
        options: [
          'default_font',
          'arial',
          'arial_black',
          'comic_sans',
          'courier_new',
          'impact',
          'lucida_grande',
          'times_new_roman',
          'verdana'
        ]
      }
    ],
    ['quote', 'unordered', 'ordered', 'outdent', 'indent'],
    ['undo', 'redo'],
    ['print', 'fullscreen'],
  ],
  editorFontSetting: {
    arial: 'Arial',
    arial_black: 'Arial Black',
    comic_sans: 'Comic Sans MS',
    courier_new: 'Courier New',
    impact: 'Impact',
    lucida_grande: 'Lucida Grande',
    times_new_roman: 'Times New Roman',
    verdana: 'Verdana'
  }
});
