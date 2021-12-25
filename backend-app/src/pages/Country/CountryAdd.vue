<template>
  <q-page class="q-pa-sm">
    <q-card>
      <q-card-section>
        <div class="text-h6 text-grey-8">
          {{ $t('addCountry') }}
          <div class="float-right">
            <BackButton></BackButton>
          </div>
        </div>
      </q-card-section>
      <q-card-section>
        <CountryForm :formData="formData" @formSubmit="onSubmit"></CountryForm>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
import {defineComponent} from 'vue'
import CountryForm from "../../components/forms/CountryForm";
import BackButton from "../../components/buttons/BackButton";
import {mapActions} from "vuex";
import notifyHelper from "src/helpers/notifyHelper";


export default defineComponent({
  name: 'CountryAdd',
  components: {
    CountryForm,
    BackButton
  },
  data: function () {
    return {
      formData: {},
    }
  },
  methods: {
    ...mapActions('country', ['storeCountry']),
    onSubmit(formData) {
      this.storeCountry({formData}).then((res) => {
        notifyHelper.success(res);
        this.$router.go(-1);
      })
    }
  },
})
</script>
