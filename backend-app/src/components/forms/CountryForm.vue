<template>
  <q-form
    @submit="onSubmit"
    class="q-gutter-md"
  >
    <q-input
      filled
      type="text"
      v-model="data.name"
      :label="$t('name')"
      :required="true"
    />
    <q-input
      filled
      type="text"
      v-model="data.iso2"
      label="ISO2"
    />
    <q-input
      filled
      type="text"
      v-model="data.iso3"
      label="ISO3"
    />
    <q-input
      filled
      type="number"
      v-model="data.phone_code"
      :label="$t('phoneCode')"
    />
    <q-input
      filled
      type="text"
      v-model="data.currency"
      :label="$t('currency')"
    />
    <q-input
      filled
      type="text"
      v-model="data.native"
      :label="$t('native')"
    />
    <div>
      <q-btn :label="$t('save')" type="submit" color="primary"/>
    </div>
  </q-form>
</template>

<script>
  import {defineComponent} from 'vue'

  export default defineComponent({
    props: {
      formData: {},
    },
    data() {
      return {
        data: this.formData,
      }
    },
    methods: {
      onSubmit() {
        this.$emit('formSubmit',this.formData)
      }
    }

  });
</script>
