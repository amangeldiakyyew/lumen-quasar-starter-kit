<template>
  <q-form
    @submit="onSubmit"
    class="q-gutter-md"
  >

    <q-input
      filled
      type="text"
      v-model="data.title"
      :label="$t('title')"
      :required="true"
    />

    <q-card class="my-card">
      <q-card-section class="q-py-sm">
        <div class="text-weight-medium">{{ $t('content') }}</div>
      </q-card-section>
      <q-editor
        v-model="data.content"
        :toolbar="toolbar"
        :fonts="fonts"
        stack-label="stack-label"
      />
    </q-card>

    <q-input
      filled
      type="text"
      v-model="data.meta_title"
      :label="$t('metaTitle')"
      :required="true"
    />
    <q-input
      filled
      type="textarea"
      v-model="data.meta_description"
      :label="$t('metaDescription')"
    />
    <q-input
      filled
      type="text"
      v-model="data.meta_keywords"
      :label="$t('metaKeywords')"
    />

    <q-input
      filled
      type="number"
      v-model="data.sort_order"
      :label="$t('sortOrder')"
    />

    <q-toggle
      v-model="data.status"
      :label="$t('status')"
      :true-value="1"
      :false-value="0"
    />

    <div>
      <q-btn :label="$t('save')" type="submit" color="primary"/>
    </div>
  </q-form>
</template>

<script>
import {defineComponent} from 'vue'
import {mapActions} from "vuex";
import helper from "../../helpers/helper";

export default defineComponent({
  props: {
    formData: {},
  },
  data() {
    console.log(this.formData)
    return {
      data: this.formData,
      categories: [],
      toolbar: helper.editorToolbarSetting,
      fonts: helper.editorFontSetting
    }
  },
  methods: {
    ...mapActions('category', ['fetchCategories']),
    onSubmit() {
      this.$emit('formSubmit', this.formData)
    }
  },

});
</script>
