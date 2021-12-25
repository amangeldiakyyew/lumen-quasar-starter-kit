<template>
  <q-page class="q-pa-sm">
    <q-card>
      <q-card-section>
        <div class="text-h6 text-grey-8">
          {{ $t('editInformationPage') }}
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
import BackButton from "../../components/buttons/BackButton";
import {mapActions} from "vuex";
import InformationForm from "components/forms/InformationForm";
import notifyHelper from "src/helpers/notifyHelper";


export default defineComponent({
  name: 'InformationEdit',
  components: {
    InformationForm,
    BackButton
  },
  data: function () {
    return {
      isReady: false,
      formData: {},
    }
  },
  methods: {
    ...mapActions('information', ['fetchSingleInformation', 'updateInformation']),
    onSubmit(formData) {
      let id = this.$route.params.id;
      this.updateInformation({id, formData}).then(res => {
        notifyHelper.success(res);
        this.$router.go(-1);
      });
    }
  },
  created() {
    let $x = this;
    this.fetchSingleInformation({id: this.$route.params.id}).then((res) => {
      $x.formData = res.data.data;
      $x.isReady = true;
    });
  }
})
</script>
