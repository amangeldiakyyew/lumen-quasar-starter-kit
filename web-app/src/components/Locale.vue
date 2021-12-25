<template>
  <q-select
    v-model="locale"
    :options="localeOptions"
    :label="$t('language')"
    dense
    borderless
    emit-value
    map-options
    options-dense
  />
</template>

<script>
import {useI18n} from 'vue-i18n'

export default {
  name: 'Locale',
  setup() {
    const {locale} = useI18n({useScope: 'global'});
    return {
      locale,
      localeOptions: [
        {value: 'tr', label: 'Tr'},
        {value: 'de', label: 'De'}
      ],
    }
  },
}
</script>
