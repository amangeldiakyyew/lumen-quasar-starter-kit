import {ref} from 'vue'

export function validationHelper() {
  const errors = ref([])

  function getErrorMessages(field) {
    if (!errors.value) {
      return []
    }
    const keys = Object.keys(errors.value)
    const key = keys.find(element => element.toLowerCase() === field.toLowerCase())
    if (errors.value[key]) {
      return errors.value[key]
    }
    return []
  }

  function getError(field) {
    const errors = getErrorMessages(field)
    if (errors.length !== 0) {
      return errors.join('\r\n')
    }
    return ''
  }

  function hasError(field) {
    return getErrorMessages(field).length !== 0;
  }

  function removeError(field) {
    if (errors.value.hasOwnProperty(field)) {
      delete errors.value[field];
    }
  }

  function setErrors(payload) {
    errors.value = payload
  }

  function showError() {
    this.$q.notify({
      type: 'negative',
      message: this.$t('failed'),
      caption: this.$t('checkInputs')
    })
  }

  return {
    showError,
    setErrors,
    getError,
    hasError,
    removeError
  }
}
