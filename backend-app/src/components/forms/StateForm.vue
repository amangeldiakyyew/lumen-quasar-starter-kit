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
      v-model="data.country_id"
      :label="$t('country')"
      :options="countries"
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
      type="text"
      v-model="data.name"
      :label="$t('name')"
      :required="true"
    />
    <q-input
      filled
      type="text"
      v-model="data.country_code"
      :label="$t('countryCode')"
    />
    <q-input
      filled
      type="text"
      v-model="data.iso2"
      label="ISO2"
    />
    <div>
      <q-btn :label="$t('save')" type="submit" color="primary"/>
    </div>
  </q-form>
</template>

<script>
import {defineComponent} from 'vue'
import helper from "src/helpers/helper";
import {mapActions} from "vuex";

export default defineComponent({
  props: {
    formData: {},
  },
  data() {
    return {
      countries: [],
      data: this.formData,
    }
  },
  methods: {
    ...mapActions('country', ['fetchCountries']),
    onSubmit() {
      this.$emit('formSubmit', this.formData)
    },
    filterFn(val, update, abort) {
      let $x = this;
      if (val.length > 1) {
        update(() => {
          this.fetchCountries({params: {q: val}}).then((res) => {
            $x.countries = res.data.data;
          });
        })
      }
    },
  },
  mounted() {
    if (helper.isObject(this.formData.country)) {
      this.countries = [this.formData.country];
    }
  }

});
</script>
