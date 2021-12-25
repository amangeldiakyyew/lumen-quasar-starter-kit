<template>
  <q-page class="q-pa-sm">
    <q-card>
      <q-card-section>
        <div class="text-h6 text-grey-8">
          {{ $t('addState') }}
          <div class="float-right">
            <BackButton></BackButton>
          </div>
        </div>
      </q-card-section>
      <q-card-section>
        <StateForm :formData="formData" @formSubmit="onSubmit"></StateForm>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
import {defineComponent} from 'vue'
import StateForm from "../../components/forms/StateForm";
import BackButton from "../../components/buttons/BackButton";
import {mapActions} from "vuex";
import notifyHelper from "src/helpers/notifyHelper";


export default defineComponent({
  name: 'StateAdd',
  components: {
    StateForm,
    BackButton
  },
  data: function () {
    return {
      formData: {},
    }
  },
  methods: {
    ...mapActions('state', ['storeState']),
    onSubmit(formData) {
      this.storeState({formData}).then((res) => {
        notifyHelper.success(res);
        this.$router.go(-1);
      })
    }
  },
})
</script>
