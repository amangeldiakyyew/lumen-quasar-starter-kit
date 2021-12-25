<template>
  <q-page class="q-pa-sm">
    <q-card>
      <q-card-section>
        <div class="text-h6 text-grey-8">
          {{$t('addUser')}}
          <div class="float-right">
            <BackButton></BackButton>
          </div>
        </div>
      </q-card-section>
      <q-card-section>
        <UserForm :formData="formData" @formSubmit="onSubmit"></UserForm>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
  import {defineComponent, ref} from 'vue'
  import UserForm from "../../components/forms/UserForm";
  import BackButton from "../../components/buttons/BackButton";
  import {mapActions} from "vuex";
  import notifyHelper from "src/helpers/notifyHelper";


  export default defineComponent({
    name: 'UserAdd',
    components: {
      UserForm,
      BackButton
    },
    data: function () {
      return {
        formData: {},
      }
    },
    methods: {
      ...mapActions('user', ['storeUser']),
      onSubmit(formData) {
        this.storeUser({formData}).then((res) => {
          notifyHelper.success(res);
          this.$router.go(-1);
        })
      }
    },
  })
</script>
