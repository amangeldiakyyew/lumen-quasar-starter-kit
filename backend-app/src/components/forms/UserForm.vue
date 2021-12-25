<template>
  <q-form
    @submit="onSubmit"
    class="q-gutter-md"
  >

    <q-input
      filled
      type="email"
      v-model="data.email"
      :label="$t('email')"
      :required="true"
    />
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
      v-model="data.surname"
      :label="$t('surname')"
      :required="true"
    />
    <q-input
      filled
      type="text"
      v-model="data.password"
      :hint="$t('passwordLeaveEmpty')"
      :label="$t('password')"
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
