<template>
  <q-form
    @submit="onSubmit"
    class="q-gutter-md"
  >

    <q-select
      filled
      use-input
      use-chips
      emit-value
      map-options
      v-model="data.parent_id"
      :label="$t('parentCategory')"
      :options="categories"
      option-value="id"
      option-label="name"
      @filter="filterFn"
    >
      <template v-slot:no-option>
        <q-item>
          <q-item-section class="text-grey">
            {{ $t('noResult') }}
          </q-item-section>
        </q-item>
      </template>
    </q-select>

    <q-input
      filled
      type="number"
      v-model="data.price"
      :label="$t('price')"
      :required="true"
    />

    <q-input
      filled
      type="text"
      v-model="data.name"
      :label="$t('name')"
      :required="true"
    />

    <q-card class="my-card">
      <q-card-section class="q-py-sm">
        <div class="text-weight-medium">{{ $t('description') }}</div>
      </q-card-section>
      <q-editor
        v-model="data.description"
        :toolbar="toolbar"
        :fonts="fonts"
        stack-label="stack-label"
      />
    </q-card>

    <q-input
      filled
      type="text"
      v-model="data.icon_class"
      label="Icon Class"
    >
      <template v-slot:after>
        <q-btn round dense flat :icon="data.icon_class"/>
      </template>
    </q-input>

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
    <q-toggle
      v-model="data.product_addable"
      :label="$t('productAddable')"
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
    return {
      data: this.formData,
      categories: [],
      toolbar: helper.editorToolbarSetting,
      fonts: helper.editorFontSetting
    }
  },
  methods: {
    ...mapActions('category', ['autocompleteCategories']),
    onSubmit() {
      if (this.parent) {
        this.data.parent_id = this.parent.id;
      }
      this.$emit('formSubmit', this.formData)
    },
    filterFn(val, update, abort) {
      let $x = this;
      if (val.length > 1) {
        update(() => {
          this.autocompleteCategories({params: {name: val}}).then((res) => {
            $x.categories = res.data.data;
          });
        })
      }
    },
  },
  mounted() {
    if (helper.isObject(this.data.parent)) {
      this.categories = [this.data.parent];
    }
  },

});
</script>
