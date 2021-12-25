<template>
  <q-page class="q-pa-sm">
    <q-card>
      <q-card-section>
        <div class="text-h6 text-grey-8">
          {{ $t('editUser') }}
          <div class="float-right">
            <BackButton></BackButton>
          </div>
        </div>
      </q-card-section>
      <q-card-section v-if="isReady">
        <UserForm :formData="formData" @formSubmit="onSubmit"></UserForm>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
import {defineComponent} from 'vue'
import UserForm from "../../components/forms/UserForm";
import BackButton from "../../components/buttons/BackButton";
import {mapActions} from "vuex";
import notifyHelper from "src/helpers/notifyHelper";


export default defineComponent({
  name: 'UserEdit',
  components: {
    UserForm,
    BackButton
  },
  data: function () {
    return {
      isReady: false,
      formData: {},
    }
  },
  methods: {
    ...mapActions('user', ['fetchUser', 'updateUser']),
    onSubmit(formData) {
      let id = this.$route.params.id;
      this.updateUser({id, formData}).then(res => {
        notifyHelper.success(res);
        this.$router.go(-1);
      });
    }
  },
  created() {
    let $x = this;
    this.fetchUser({id: this.$route.params.id}).then((res) => {
      $x.formData = res.data.data;
      $x.isReady = true;
    });
  }
})
</script>
