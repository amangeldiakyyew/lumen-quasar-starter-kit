<template>
  <q-page class="q-pa-sm">
    <q-card>
      <q-card-section>
        <div class="text-h6 text-grey-8">
          {{$t('addInformationPage')}}
          <div class="float-right">
            <BackButton></BackButton>
          </div>
        </div>
      </q-card-section>
      <q-card-section v-if="isReady">
        <InformationForm :formData="formData" @formSubmit="onSubmit"></InformationForm>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
  import {defineComponent} from 'vue'
  import InformationForm from "components/forms/InformationForm";
  import BackButton from "../../components/buttons/BackButton";
  import {mapActions} from "vuex";
  import notifyHelper from "src/helpers/notifyHelper";


  export default defineComponent({
    name: 'InformationAdd',
    components: {
      InformationForm,
      BackButton
    },
    data: function () {
      return {
        isReady: true,
        formData: {
          content: '',
          status: 1,
        },
      }
    },
    methods: {
      ...mapActions('information', ['storeInformation']),
      onSubmit(formData) {
        this.storeInformation({formData}).then(res => {
          notifyHelper.success(res);
          this.$router.go(-1);
        });
      }
    },
  })
</script>
