<template>
  <q-page class="q-pa-sm">
    <q-card>
      <q-card-section>
        <div class="text-h6 text-grey-8">
          {{$t('addCategory')}}
          <div class="float-right">
            <BackButton></BackButton>
          </div>
        </div>
      </q-card-section>
      <q-card-section v-if="isReady">
        <CategoryForm :formData="formData" @formSubmit="onSubmit"></CategoryForm>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
  import {defineComponent} from 'vue'
  import CategoryForm from "../../components/forms/CategoryForm";
  import BackButton from "../../components/buttons/BackButton";
  import {mapActions} from "vuex";
  import notifyHelper from "src/helpers/notifyHelper";


  export default defineComponent({
    name: 'CategoryAdd',
    components: {
      CategoryForm,
      BackButton
    },
    data: function () {
      return {
        isReady: true,
        formData: {
          parent_id: null,
          description: '',
          status: 1,
          product_addable: 0,
        },
      }
    },
    methods: {
      ...mapActions('category', ['storeCategory']),
      onSubmit(formData) {
        this.storeCategory({formData}).then(res => {
          notifyHelper.success(res.data);
          this.$router.go(-1);
        });
      }
    },
  })
</script>
