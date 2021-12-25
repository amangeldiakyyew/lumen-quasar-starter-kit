<template>
  <q-page class="q-pa-sm">
    <q-card>
      <q-card-section>
        <div class="text-h6 text-grey-8">
          {{ $t('editState') }}
          <div class="float-right">
            <BackButton></BackButton>
          </div>
        </div>
      </q-card-section>
      <q-card-section v-if="isReady">
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
  name: 'StateEdit',
  components: {
    StateForm,
    BackButton
  },
  data: function () {
    return {
      isReady: false,
      formData: {},
    }
  },
  methods: {
    ...mapActions('state', ['fetchState', 'updateState']),
    onSubmit(formData) {
      let id = this.$route.params.id;
      this.updateState({id, formData}).then(res => {
        notifyHelper.success(res);
        this.$router.go(-1);
      });
    }
  },
  created() {
    let $x = this;
    this.fetchState({id: this.$route.params.id, params: {with: ['country']}}).then((res) => {
      $x.formData = res.data.data;
      $x.isReady = true;
    });
  }
})
</script>
